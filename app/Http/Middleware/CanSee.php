<?php

namespace SimPas\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SimPas\Repository\PastebinRecord;

class CanSee
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
        $uniqueId = $request->route()->bindParameters($request)['unique_id'];
        $entity = PastebinRecord::where('unique_id', $uniqueId)->first();

        if (!$entity) {
            abort(404);
        }

        if ($entity->is_private === true && $entity->user_id !== 0) {
            if (Auth::guest() === true) {
                abort(403);
            }

            if ($entity->isAuthor()) {
                return $next($request);
            }

            abort(403);
        }

        return $next($request);
    }
}
