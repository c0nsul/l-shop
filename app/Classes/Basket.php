<?php

namespace App\Classes;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
     * @param $email
     * @return false
     */
    public function saveOrder($name, $phone, $email)
    {
        if (!$this->countAvailable(true)) {
            return false;
        }
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));

        return $this->order->saveOrder($name, $phone);
    }

    /**
     * @return bool
     */
    public function countAvailable($updateCount = false)
    {
        foreach ($this->order->products as $orderProduct) {
            if ($orderProduct->count < $this->getPivotRow($orderProduct)->count) {
                return false;
            }

            if ($updateCount) {
                $orderProduct->count -= $this->getPivotRow($orderProduct)->count;
            }
        }

        if ($updateCount) {
            $this->order->products->map->save();
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
                session()->flash('warning',  __('basket.removed'). $product->name);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
                session()->flash('warning', __('basket.removed'). $product->name);
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
                session()->flash('warning', $product->name . __('basket.you_cant_order_more'));
                return false;
            }

            session()->flash('success', __('basket.added').$product->name);
            $pivotRow->update();
        } else {
            if ($product->count == 0) {
                return false;
            }
            $this->order->products()->attach($product->id);
            session()->flash('success', __('basket.added') . $product->name);
        }

        Order::changeFullSum($product->price);

        return true;
    }
}
