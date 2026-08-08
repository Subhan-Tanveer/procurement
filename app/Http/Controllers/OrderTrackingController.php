<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function show()
    {
        return view('site.order-tracking');
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $order = Order::with(['items.product', 'statusHistory.changedBy'])
            ->where('order_number', $validated['order_number'])
            ->where('customer_email', $validated['email'])
            ->first();

        if (!$order) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'We could not find an order with those details. Please double-check and try again.');
        }

        return view('site.order-tracking', compact('order'));
    }
}
