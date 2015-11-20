<?php

namespace App\Http\Middleware;

use Closure;

class EasyAuthAdminMiddleware
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
        $userID = intval($request->header('userID'));
        if ($userID > 0){
            $user = User::findOrFail($userID);
            $hash = md5('secret-'.$user->device_token.'<>'.$request->path().'<>'. $request->header('date') . '-santa');
            if ($hash !== $request->header('authToken') || !$user->isAdmin()) {
                return response([], 403);
            }
            $request->attributes->add(['user' => $user]);
        } else {
            return response([], 403);
        }
        
        return $next($request);
    }
}

