@extends('layouts.master')

@section('title', 'Товар')

@section('content')
        <h5>{{$product->Category->name}}</h5>
        <h1>{{$product->name}}</h1>
        <p>Price: <b>{{$product->price}} rub.</b></p>
        <div >
            @if($product->isNew())
                <span class="badge badge-success">Новинка</span>
            @endif

            @if($product->isRecommend())
                <span class="badge badge-warning">Рекомендуем</span>
            @endif

            @if($product->isHit())
                <span class="badge badge-danger">Хит продаж!</span>
            @endif
        </div>
        <img src="{{Storage::url($product->image)}}">
        <p>{{$product->description}}</p>

        @if($product->isAvailable())
            <form action="{{route('basket-add', $product)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-success" role="button">Add to basket</button>
            </form>
        @else
            <span class="h4 text-danger">Not available</span>
            <br>
            <br>
            <span>Message me when product will be available:</span>

            <form method="POST" action="{{ route('subscription', $product) }}">
                @csrf
                <input type="text" name="email"></input>
                <button type="submit">Send</button>
            </form>
            <div class="warning text-danger">
                @if($errors->get('email'))
                    {!! $errors->get('email')[0] !!}
                @endif
            </div>
        @endif

@endsection
