<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
session_start();
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle(Request $request, Closure $next)
    {
        $customer_id = session()->get('customer_id');
        if(isset($customer_id)) {
            return $next($request);
        }
        else {
            return redirect('/');
        }
    }
}
