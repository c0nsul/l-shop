<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{

    /**
     * @param Request $request
     * @param Order $orderModel
     * @return RedirectResponse
     */
    public function basketConfirm(Request $request, Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        if (is_null($sessionOrderId)) {
            return redirect()->route('index');
        }
        $order = $orderModel::find($sessionOrderId);
        $success = $order->saveOrder($request->name, $request->phone);

        if ($success) {
            session()->flash('success', 'Thanks for your order!');
        } else {
            session()->flash('warning', 'Something went wrong');
        }

        return redirect()->route('index');
    }

    /**
     * @param Order $orderModel
     * @return Application|Factory|View
     */
    public function basket(Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        $order = !empty($sessionOrderId) ? $orderModel->findOrFail($sessionOrderId) : null;
        return view('basket', compact('order'));
    }

    /**
     * @param Order $orderModel
     * @return Application|Factory|View|RedirectResponse
     */
    public function basketPlace(Order $orderModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            return redirect()->route('index');
        }
        $order = !empty($sessionOrderId) ? $orderModel->findOrFail($sessionOrderId) : null;
        return view('order', compact('order'));
    }

    /**
     * @param $id
     * @param Order $orderModel
     * @param Product $productModel
     * @return RedirectResponse
     */
    public function basketAdd($id, Order $orderModel, Product $productModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            $order = $orderModel->create();
            session(['orderId' => $order->id]);
        } else {
            $order = $orderModel->find($sessionOrderId);
        }

        $product = $productModel::find($id);

        if ($order->products->contains($id)) {
            $pivotRow = $order->products()->where('product_id', $id)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();
            session()->flash('success', $product->name.' counter increased!');
        } else {
            $order->products()->attach($id);
            session()->flash('success', $product->name.' added to basket!');
        }

        if (Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }

        return redirect()->route('basket');
    }

    /**
     * @param $id
     * @param Order $orderModel
     * @param Product $productModel
     * @return RedirectResponse
     */
    public function basketRemove($id, Order $orderModel, Product $productModel)
    {
        $sessionOrderId = session('orderId');
        if (!$sessionOrderId) {
            return redirect()->route('basket');
        } else {
            $order = $orderModel->find($sessionOrderId);
        }

        $product = $productModel::find($id);

        if ($order->products->contains($id)) {
            $pivotRow = $order->products()->where('product_id', $id)->first()->pivot;
            if ($pivotRow->count >= 2) {
                $pivotRow->count--;
                $pivotRow->update();
                session()->flash('warning', $product->name.' counter decreased!');
            } else {
                $order->products()->detach($id);
                session()->flash('warning', $product->name.' removed from basket!');
            }
        }

        return redirect()->route('basket');
    }
}
