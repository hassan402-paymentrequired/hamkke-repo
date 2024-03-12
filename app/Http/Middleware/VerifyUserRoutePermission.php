<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User $authUser
         */
        $authUser = $request->user();
        if(currentRouteIsPermissionProtected($request) && !$authUser->can($request->route()->getName())){
            return abort(403, 'Permission Denied!!');
        }
        return $next($request);
    }
}
