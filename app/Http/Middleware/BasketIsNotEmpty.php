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
        if (!is_null($sessionOrderId)) {
            $order = Order::findOrFail($sessionOrderId);
            if ($order->products->count() == 0) {
                session()->flash('warning', 'Your basket is empty');
                return redirect()->route('index');
            }
        }
        return $next($request);
    }
}
