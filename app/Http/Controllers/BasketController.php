<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
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
     * @return Application|Factory|View
     */
    public function basket(Basket $basket)
    {
        $order = $basket->getOrder();

        return view('basket', compact('order'));
    }

    /**
     * @return Application|Factory|View
     */
    public function basketPlace(Basket $basket)
    {
        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning', __('basket.you_cant_order_more'));
            return redirect()->route('basket');
        }
        return view('order', compact('order'));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function basketAdd(Product $product)
    {
        (new Basket(true))->addProduct($product);

        return redirect()->route('basket');
    }

    /**
     * @param Product $product
     * @param Basket $basket
     * @return RedirectResponse
     */
    public function basketRemove(Product $product, Basket $basket)
    {
        $basket->removeProduct($product);

        return redirect()->route('basket');
    }

    /**
     * @param Request $request
     * @param Basket $basket
     * @return RedirectResponse
     */
    public function basketConfirm(Request $request, Basket $basket)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;
        $success = $basket->saveOrder($request->name, $request->phone, $request->email, $email);

        if ($success) {
            session()->flash('success',  __('basket.you_order_confirmed'));
        } else {
            session()->flash('warning', __('basket.you_cant_order_more'));
        }
        Order::eraseOrderSum();
        return redirect()->route('index');
    }
}
