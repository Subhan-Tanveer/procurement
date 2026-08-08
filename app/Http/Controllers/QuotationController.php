<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Models\Quotation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{
    /**
     * Store a new quotation request.
     */
    public function store(StoreQuotationRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Create quotation
            $quotation = Quotation::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_company' => $validated['customer_company'] ?? null,
                'subject' => $validated['subject'] ?? 'Quote Request',
                'message' => $validated['message'] ?? null,
                'status' => 'new',
            ]);

            // If product is specified, create quotation item
            if (!empty($validated['product_id'])) {
                $product = Product::findOrFail($validated['product_id']);
                $quantity = $validated['quantity'] ?? 1;

                $quotation->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $quantity,
                    'specifications' => $validated['specifications'] ?? null,
                ]);

                // Update quotation total
                $quotation->update([
                    'total_amount' => $product->price * $quantity,
                ]);
            }

            DB::commit();

            // TODO: Send email notification to admin
            // Mail::to(config('mail.admin_email'))->send(new QuoteRequestReceived($quotation));

            return redirect()
                ->back()
                ->with('success', 'Your quote request has been submitted successfully! We will contact you soon.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote submission failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit quote request. Please try again or contact us directly.');
        }
    }

    /**
     * Display the quotation confirmation page.
     */
    public function success()
    {
        return view('site.quotation-success');
    }
}
