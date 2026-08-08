<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations.
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('quote_number', 'like', $searchTerm)
                  ->orWhere('customer_name', 'like', $searchTerm)
                  ->orWhere('customer_email', 'like', $searchTerm)
                  ->orWhere('customer_company', 'like', $searchTerm);
            });
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(20);

        $statusCounts = [
            'all' => Quotation::count(),
            'new' => Quotation::where('status', 'new')->count(),
            'pending' => Quotation::where('status', 'pending')->count(),
            'quoted' => Quotation::where('status', 'quoted')->count(),
        ];

        return view('admin.quotations.index', compact('quotations', 'statusCounts'));
    }

    /**
     * Display the specified quotation.
     */
    public function show(Quotation $quotation)
    {
        if (in_array($quotation->status, ['new', 'reviewed'], true)) {
            $quotation->update(['status' => 'pending']);
            $quotation->refresh();
        }

        $quotation->load(['items.product', 'order', 'approvedBy', 'rejectedBy', 'paidBy']);
        $users = \App\Models\User::where('is_active', true)->orderBy('name')->get();

        return view('admin.quotations.show', compact('quotation', 'users'));
    }

    /**
     * Update quotation status.
     */
    public function updateStatus(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status'       => 'sometimes|in:accepted,rejected',
            'notes'        => 'nullable|string|max:5000',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        if ($request->filled('status') && $request->status === 'accepted' && !auth()->user()->hasPermission('quotations.accept')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->filled('status') && $request->status === 'rejected' && !auth()->user()->hasPermission('quotations.reject')) {
            abort(403, 'Unauthorized action.');
        }

        $originalStatus = $quotation->status;

        if (array_key_exists('status', $validated)) {
            if ($validated['status'] === 'accepted') {
                $validated['responded_at'] = now();
                $validated['approved_by'] = auth()->id();
                $validated['rejected_by'] = null;
            }

            if ($validated['status'] === 'rejected') {
                $validated['responded_at'] = now();
                $validated['rejected_by'] = auth()->id();
                $validated['approved_by'] = null;
                $validated['paid_at'] = null;
                $validated['paid_by'] = null;
            }
        }

        $quotation->update($validated);

        if (array_key_exists('status', $validated) && $validated['status'] !== $originalStatus) {
            if ($validated['status'] !== 'accepted' && $quotation->paid_at) {
                $quotation->update([
                    'paid_at' => null,
                    'paid_by' => null,
                ]);
            }
        }

        return redirect()
            ->route('admin.quotations.show', $quotation)
            ->with('success', 'Quotation updated successfully!');
    }

    /**
     * Mark an accepted quotation invoice as paid.
     */
    public function markPaid(Quotation $quotation)
    {
        if ($quotation->status !== 'accepted') {
            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('error', 'Only accepted quotations can be marked as paid.');
        }

        if ($quotation->paid_at) {
            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('info', 'This quotation is already marked as paid.');
        }

        $quotation->update([
            'paid_at' => now(),
            'paid_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.quotations.show', $quotation)
            ->with('success', 'Invoice marked as paid successfully.');
    }

    /**
     * Delete the quotation.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()
            ->route('admin.quotations.index')
            ->with('success', 'Quotation deleted successfully!');
    }

    /**
     * Convert quotation to order.
     */
    public function convertToOrder(Quotation $quotation)
    {
        if ($quotation->order) {
            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('error', 'This quotation has already been converted to an order.');
        }

        if (!$quotation->paid_at) {
            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('error', 'Mark the invoice as paid before converting to an order.');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'quotation_id' => $quotation->id,
                'assigned_to' => auth()->id(),
                'customer_name' => $quotation->customer_name,
                'customer_email' => $quotation->customer_email,
                'customer_phone' => $quotation->customer_phone,
                'customer_company' => $quotation->customer_company,
                'status' => 'created',
                'total_amount' => $quotation->total_amount ?? 0,
                'currency' => $quotation->currency ?? 'USD',
                'notes' => $quotation->notes,
            ]);

            $quotation->items()->each(function ($item) use ($order) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity ?? 1,
                    'unit_price' => $item->unit_price ?? 0,
                    'total_price' => $item->total_price ?? 0,
                    'specifications' => $item->specifications,
                    'notes' => $item->notes,
                ]);
            });

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'changed_by' => auth()->id(),
                'status' => 'created',
                'note' => 'Order created from quotation ' . $quotation->quote_number,
            ]);

            if ($quotation->status !== 'accepted') {
                $quotation->update(['status' => 'accepted']);
            }

            DB::commit();

            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('success', 'Order created successfully from quotation.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.quotations.show', $quotation)
                ->with('error', 'Failed to convert quotation: ' . $e->getMessage());
        }
    }
}
