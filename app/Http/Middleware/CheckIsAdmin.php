<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user->isAdmin()){
            //session()->flash('success', 'Welcome back '.$user->name);
            return redirect()->route('index');
        }
        //session()->flash('success', 'Welcome back Admin!');
        return $next($request);
    }
}
