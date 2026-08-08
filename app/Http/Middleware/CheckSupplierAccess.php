<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSupplierAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->is_active || $user->role !== 'supplier') {
            abort(403);
        }

        $profile = $user->supplierProfile;

        if (!$profile) {
            return redirect()->route('supplier.register');
        }

        if ($profile->status === 'pending_review') {
            return redirect()->route('supplier.pending');
        }

        if (in_array($profile->status, ['rejected', 'suspended'], true)) {
            return redirect()->route('supplier.pending');
        }

        return $next($request);
    }
}
