<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function basket(Order $orderModel) {
        $sessionOrderId = session('orderId');
        $order = !empty($sessionOrderId) ? $orderModel->findOrFail($sessionOrderId) : null;
        return view('basket', compact('order'));
    }

    public function basketPlace() {
        return view('order');
    }

    public function basketAdd($id, Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            $order = $orderModel->create();
            session(['orderId' => $order->id]);
        } else {
            $order = $orderModel->find($sessionOrderId);
        }
        $order->products()->attach($id);

        return view('basket', compact('order'));
    }

    public function basketRemove($id, Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            return false;
        } else {
            $order = $orderModel->find($sessionOrderId);
        }
        $order->products()->detach($id);

        return view('basket', compact('order'));
    }
}
