<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class BasketIsNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param Order $orderModel
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionOrderId = session('orderId');

        if (!is_null($sessionOrderId) && Order::getFullSum() > 0) {
                return $next($request);
        }
        session()->flash('warning', 'Your basket is empty');
        return redirect()->route('index');
    }
}
