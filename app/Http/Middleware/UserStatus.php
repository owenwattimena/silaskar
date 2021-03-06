<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = User::findOrFail(\Auth::user()->id);

        if(\Auth::user()->status != 'active')
        {
            $alert = [
                "type" => "alert-danger",
                "msg"  => "Akun anda di blokir. Hubungi administrator untuk mengaktifkan."
            ];
            return redirect()->route('login')->with($alert);
        }
        return $next($request);
    }
}