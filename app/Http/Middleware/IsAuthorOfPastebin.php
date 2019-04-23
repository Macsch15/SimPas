<?php

namespace SimPas\Http\Middleware;

use Closure;
use SimPas\Models\PastebinRecord;

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
        $uniqueId = $request->route()->parameters['unique_id'];
        $entity = PastebinRecord::where('unique_id', $uniqueId)->first();

        if (!$entity) {
            abort(404);
        }

        if (!$entity->isAuthor()) {
            return abort(403);
        }

        return $next($request);
    }
}
