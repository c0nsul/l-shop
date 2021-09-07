@extends('master')

@section('title', 'Корзина')

@section('content')
    <div class="starter-template">
        <h1>Basket</h1>
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
                                <a href="{{ route('product', [$product->category->code, $product->code]) }}">
                                    <img height="56px" src="/storage/products/{{$product->code}}.jpg">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td><span class="badge">1</span>
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
                            <td>{{ $product->price }} руб.</td>
                            <td>{{ $product->price }} руб.</td>
                        </tr>
                    @endforeach
                @endisset
                <tr>
                    <td colspan="3">Final price:</td>
                    <td>71990 руб.</td>
                </tr>
                </tbody>
            </table>
            <br>
            <div class="btn-group pull-right" role="group">
                <a type="button" class="btn btn-success" href="/basket/place">Checkout</a>
            </div>
        </div>
    </div>
@endsection
