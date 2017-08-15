<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Facades\Admin;
use App\Models\Projects;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Admin::user()->isAdministrator()) {
            $project = Projects::findOrfail($request->route('project'));
            if($project->user_id != Admin::user()->id) {
                return redirect('/');
            }
        }
        return $next($request);
    }
}
