<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;

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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Order $orderModel)
    {
        $orders = $orderModel::where("status", $orderModel::ORDER_STATUS_1)->get();
        return view("auth.orders.index", compact("orders"));
    }
}
