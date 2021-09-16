<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $pageLimit = 10;

    public function index()
    {
        $orders = Auth::user()->orders()->active()->paginate($this->pageLimit);
        return view('auth.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!Auth::user()->orders->contains($order)) {
            return back();
        }

        return view('auth.orders.show', compact('order'));
    }
}
