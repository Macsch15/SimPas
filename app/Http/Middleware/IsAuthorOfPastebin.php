<?php

namespace SimPas\Http\Middleware;

use Closure;
use SimPas\Repository\PastebinRecord;

class IsAuthorOfPastebin
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
        $unique_id = $request->route()->bindParameters($request)['unique_id'];
        $entity = PastebinRecord::where('unique_id', $unique_id)->first();

        if (!$entity) {
            abort(404);
        }

        if (!$entity->isAuthor()) {
            return abort(403);
        }

        return $next($request);
    }
}
