<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest() && !$this->shouldPassThrough($request)) {
            return redirect()->guest(Admin::url('auth/login'));
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $excepts = [
            Admin::url('auth/login'),
            Admin::url('auth/logout'),
            Admin::url('auth/register'),
            Admin::url('register/confirm/{token}'),
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->is($except) || $request->is('register/confirm/*')) {
                return true;
            }
        }

        return false;
    }
}
