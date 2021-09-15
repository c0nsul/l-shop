@extends('layouts.master')

@section('title', 'Корзина')

@section('content')
        <h1>Basket</h1>
        @if(isset($order->products) && count($order->products)>0)
        <p>Checkout</p>
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
                                <div class="btn-group">
                                    <form action="{{ route('basket-remove', $product) }}" method="POST">
                                        <button type="submit" class="btn btn-danger" href="#">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                        </button>
                                        @csrf
                                    </form>

                                    <form action="{{ route('basket-add', $product) }}" method="POST">
                                        <button type="submit" class="btn btn-success" href="#">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                        @csrf
                                    </form>
                                </div>
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
                    <a type="button" class="btn btn-success" href="{{route("basket-place")}}">Checkout</a>
            </div>
        </div>
        @else
        <div class="panel" >
            Basket is empty!
        </div>
        @endif
@endsection
