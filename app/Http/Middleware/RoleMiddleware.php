<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!$request->user()->hasRole($role)) {
            abort(403);
        }

        if (!$request->user()->hasRolePermission($role,$permission)) {
            abort(403);
        }

        if ($request->user()->hasRole('vendor')) {
            $user = auth()->user();
            if (count($user->locations) == 0 && !request()->routeIs('vendor.no-locations')) {
                $user->settings = null;
                $user->save();
                return redirect()->route('vendor.no-locations');
            }
            if (!$user->settings || !isset($user->settings['selectedLocation'])) {
                $id = $user->locations->count() > 0 ? $user->locations->first()->id : null;
                $user->settings = $id ? collect(['selectedLocation' => $id])->toJson() : null;
                $user->save();
            }

            if ($request->search != '' && !request()->routeIs('vendor.shipment.trade-ins')) {
                return redirect()->route('vendor.shipment.trade-ins', ['search' => $request->search]);
            }
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
