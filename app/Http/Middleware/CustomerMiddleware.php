<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            abort(403, 'Access denied. Authentication required.');
        }

        if (Auth::user()->isCustomer()) {
            return $next($request);
        }

        if (Auth::user()->isShipper()) {
            return redirect()->route('shipper.dashboard')
                ->with('error', 'Tai khoan nguoi giao hang khong the mua hang hoac su dung gio hang.');
        }

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Tai khoan quan tri khong the mua hang bang luong khach hang.');
        }

        abort(403, 'Access denied. Customer privileges required.');
    }
}
