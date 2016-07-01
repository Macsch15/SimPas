<?php

namespace SimPas\Http\Middleware;

use SimPas\Repository\PastebinRecord;
use Auth;
use Closure;

class IsAuthorOfPastebin
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

        if (Auth::id() !== $entity->user_id) {
            return abort(403);
        }

        return $next($request);
    }
}
