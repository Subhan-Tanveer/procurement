<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['quotation'])->withCount('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', $term)
                  ->orWhere('customer_name', 'like', $term)
                  ->orWhere('customer_email', 'like', $term)
                  ->orWhere('customer_company', 'like', $term)
                  ->orWhere('tracking_ref', 'like', $term);
            });
        }

        $orders = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $statusCounts = [
            'all' => Order::count(),
            'created' => Order::where('status', 'created')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'dispatched' => Order::where('status', 'dispatched')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'statusHistory.changedBy', 'quotation']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status and logistics data.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:created,confirmed,processing,dispatched,delivered,cancelled',
            'tracking_ref' => 'nullable|string|max:255',
            'carrier' => 'nullable|string|max:255',
            'delivery_address' => 'nullable|string',
            'delivery_contact' => 'nullable|string|max:255',
            'delivery_phone' => 'nullable|string|max:50',
            'expected_delivery_at' => 'nullable|date',
            'actual_delivery_at' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
        ]);

        $statusChanged = $order->status !== $validated['status'];

        $order->update([
            'status' => $validated['status'],
            'tracking_ref' => $validated['tracking_ref'] ?? $order->tracking_ref,
            'carrier' => $validated['carrier'] ?? $order->carrier,
            'delivery_address' => $validated['delivery_address'] ?? $order->delivery_address,
            'delivery_contact' => $validated['delivery_contact'] ?? $order->delivery_contact,
            'delivery_phone' => $validated['delivery_phone'] ?? $order->delivery_phone,
            'expected_delivery_at' => $validated['expected_delivery_at'] ?? $order->expected_delivery_at,
            'actual_delivery_at' => $validated['actual_delivery_at'] ?? $order->actual_delivery_at,
        ]);

        if ($statusChanged || !empty($validated['note'])) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'changed_by' => auth()->id(),
                'status' => $validated['status'],
                'note' => $validated['note'] ?? ($statusChanged ? 'Status updated to ' . $validated['status'] : null),
            ]);
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }
}
