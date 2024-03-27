<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfCustomer
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponseAlias|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard(CUSTOMER_GUARD_NAME)->check()) {
            // If the user is authenticated with the "customer" guard,
            // redirect them to a specific route or URL
            if($request->isMethod('GET')) {
                session()->put('url.intended', $request->fullUrl());
            }
            return redirect()->route('customer.auth.login');
        }

        return $next($request);
    }
}
