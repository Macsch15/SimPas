<?php

namespace SimPas\Http\Middleware;

use Closure;
use Auth;
use SimPas\Repository\PastebinRecord;

class CanSee
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
        $unique_id = $request->route()->bindParameters($request)['unique_id'];
        $entity = PastebinRecord::where('unique_id', $unique_id)->first();

        if ($entity->is_private === true && $entity->user_id !== 0) {
            if (Auth::guest() === true) {
                abort(403);
            }

            if (Auth::id() === $entity->user_id) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
