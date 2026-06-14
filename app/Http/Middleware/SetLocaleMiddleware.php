<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    public function handle($request, \Closure $next)
    {
        // Αν υπάρχει επιλεγμένη γλώσσα στο session, τη χρησιμοποιούμε. Διαφορετικά, default τα αγγλικά ('en')
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        } else {
            app()->setLocale('en');
        }

        return $next($request);
    }
}
