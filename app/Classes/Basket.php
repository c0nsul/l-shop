<?php

namespace App\Classes;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Basket
{
    protected $order;

    /**
     * Basket constructor.
     * @param bool $createOrder
     */
    public function __construct(bool $createOrder = false)
    {
        $orderId = session('orderId');

        if (is_null($orderId) && $createOrder) {

            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }

            $this->order = Order::create($data);
            session(['orderId' => $this->order->id]);
        } else {
            $this->order = Order::findOrFail($orderId);
        }
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $name
     * @param $phone
     * @return false
     */
    public function saveOrder($name, $phone)
    {
        if (!$this->countAvailable()) {
            return false;
        }
        return $this->order->saveOrder($name, $phone);
    }

    /**
     * @return bool
     */
    public function countAvailable()
    {
        foreach ($this->order->products as $orderProduct) {
            if ($orderProduct->count < $this->getPivotRow($orderProduct)->count) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $product
     * @return mixed
     */
    protected function getPivotRow($product)
    {
        return $this->order->products()->where('product_id', $product->id)->first()->pivot;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {

        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            if ($pivotRow->count < 2) {
                $this->order->products()->detach($product->id);
                session()->flash('warning', $product->name . ' removed from basket!');
            } else {
                $pivotRow->count--;
                $pivotRow->update();
                session()->flash('warning', $product->name . ' counter decreased!');
            }
        }

        Order::changeFullSum(-$product->price);
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function addProduct(Product $product)
    {
        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            $pivotRow->count++;
            if ($pivotRow->count > $product->count) {
                session()->flash('warning', $product->name . ' more items is not available!');
                return false;
            }
            session()->flash('success', $product->name . ' counter increased!');
            $pivotRow->update();
        } else {
            if ($product->count == 0) {
                return false;
            }
            $this->order->products()->attach($product->id);
            session()->flash('success', $product->name . ' added to basket!');
        }

        Order::changeFullSum($product->price);

        return true;
    }
}
