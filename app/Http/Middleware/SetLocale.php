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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from route parameter
        $locale = $request->route('locale');
        
        // Define supported locales (you can move this to config if needed)
        $supportedLocales = ['az', 'en', 'ru'];
        
        // Check if locale is valid
        if ($locale && in_array($locale, $supportedLocales)) {
            // Set application locale
            App::setLocale($locale);
            
            // Store locale in session for future requests
            Session::put('locale', $locale);
        } else {
            // If locale is invalid, redirect to default locale
            $defaultLocale = config('app.locale', 'az');
            
            // Get current path without locale prefix
            $path = $request->path();
            if (preg_match('/^[a-zA-Z]{2}\/(.*)$/', $path, $matches)) {
                $path = $matches[1];
            }
            
            return redirect()->to('/' . $defaultLocale . '/' . $path);
        }
        
        return $next($request);
    }
}
