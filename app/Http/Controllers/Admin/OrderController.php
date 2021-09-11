<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Order $orderModel
     * @return Application|Factory|View
     */
    public function index(Order $orderModel)
    {
        $orders = $orderModel::where("status", $orderModel::ORDER_STATUS_1)->get();
        return view("auth.orders.index", compact("orders"));
    }

    /**
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        return view("auth.orders.show", compact("order"));
    }
}
