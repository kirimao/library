<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     * Sets the application locale based on session preference.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, ['id', 'en'])) {
                App::setLocale($locale);
            }
        } else {
            App::setLocale('id'); // Default to Indonesian
        }

        return $next($request);
    }
}
