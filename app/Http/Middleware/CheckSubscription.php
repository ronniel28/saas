<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $company = app()->bound('currentTenant')
            ? app('currentTenant')
            : auth()->user()?->company;

        if (! $company) {
            return response()->json([
                'message' => 'Tenant context is missing.'
            ], 403);
        }

        $subscription = $company->subscriptions()
            ->where('status', 'active')
            ->first();

        if (! $subscription) {
            return response()->json([
                'message' => 'No active subscription.'
            ], 403);
        }

        if ($subscription->ends_at && now()->greaterThan($subscription->ends_at)) {
            return response()->json([
                'message' => 'Subscription expired.'
            ], 403);
        }

        return $next($request);
    }

}
