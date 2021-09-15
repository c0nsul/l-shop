@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
    <h1>Order {{$order->id}}</h1>
    @if(isset($order->products) && count($order->products)>0)
        <p>Order Details:</p>
        <br/>
        <p>Name: <b>{{ $order->name }}</b></p>
        <p>Phone: <b>{{ $order->phone }}</b></p>


        <div class="panel">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Price</th>
                    <th>Final price</th>
                </tr>
                </thead>
                <tbody>
                @isset($order->products)
                    @foreach($order->products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('product', [isset($category) ? $category->code : $product->Category->code, $product->code]) }}">
                                    <img height="56px" src="{{Storage::url($product->image)}}">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td><span class="badge">{{ $product->pivot->count }}</span>
                            </td>
                            <td>{{ $product->price }} rub.</td>
                            <td>{{ $product->getPriceCalculation($product->pivot->count) }} rub.</td>
                        </tr>
                    @endforeach
                @endisset
                <tr>
                    <td colspan="3">Total:</td>
                    <td>{{ isset( $order) ? $order->getFullSum() : 0 }} rub.</td>
                </tr>
                </tbody>
            </table>
            <br>
            <div class="btn-group pull-right" role="group">
                <a type="button" class="btn btn-success"
                   @admin
                        href="{{route("home")}}"
                   @else
                       href="{{route("person.orders.index")}}"
                   @endadmin
                       >Back to orders</a>
            </div>
        </div>
    @endif
@endsection
