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

        if ($order->products->contains($id)) {
            $pivotRow = $order->products()->where('product_id', $id)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();
        } else {
            $order->products()->attach($id);
        }

        return redirect()->route('basket');
    }

    public function basketRemove($id, Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            return redirect()->route('basket');
        } else {
            $order = $orderModel->find($sessionOrderId);
        }

        if ($order->products->contains($id)) {
            $pivotRow = $order->products()->where('product_id', $id)->first()->pivot;
            if ($pivotRow->count >= 2) {
                $pivotRow->count--;
                $pivotRow->update();
            } else {
                $order->products()->detach($id);
            }
        }

        return redirect()->route('basket');
    }
}
