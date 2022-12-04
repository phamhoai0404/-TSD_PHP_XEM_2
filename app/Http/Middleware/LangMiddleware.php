<?php

namespace App\Http\Middleware;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App;
use Auth;
use App\Entities\User;

class LangMiddleware
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
        $user = Auth::User();
        if(empty($user)){
            App::setLocale(DEFAULT_LANG_CODE);
        } else {
            App::setLocale($user->language);
        }
        return $next($request);
    }
}
