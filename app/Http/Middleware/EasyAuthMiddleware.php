<?php

namespace App\Http\Middleware;

use Closure;

class EasyAuthMiddleware
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
        $userID = $request->header('userdID');
        if (is_int($userID)){
            $user = App\User::findOrFail($userID);
            
            if (md5('secret-'+$user->deviceToken+'<>'+$request->path()+'<>'+ $request->header('date') + '-santa') !== $request->header('authToken')) {
                return response($content, 403);
            }
        } 
        return $next($request);
    }
}
