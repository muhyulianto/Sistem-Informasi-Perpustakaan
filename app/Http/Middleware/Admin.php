<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Session;

class Admin
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
        if (User::all()->count() != 0){
            Session::flash('error', 'Hanya 1 admin yang bisa terdaftar, silahkan login!!!');
            return redirect('/login');
        }

        return $next($request);
    }
}
