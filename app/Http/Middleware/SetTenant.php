<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $company = auth()->user()->company;

        if (! $company || ! $company->is_active) {
            return response()->json([
                'message' => 'Invalid or inactive tenant.'
            ], 403);
        }

        // Bind current tenant into container
        App::instance('currentTenant', $company);

        return $next($request);
    }

}
