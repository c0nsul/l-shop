@extends('layouts.master')

@section('title', __('main.product'))

@section('content')
        <h5>{{$product->Category->name}}</h5>
        <h1>{{$product->name}}</h1>
        <p>@lang('product.price'): <b>{{ $product->price }} @lang('main.rub').</b></p>
        <div >
            @if($product->isNew())
                <span class="badge badge-success">@lang('main.properties.new')</span>
            @endif

            @if($product->isRecommend())
                    <span class="badge badge-warning">@lang('main.properties.recommend')</span>
            @endif

            @if($product->isHit())
                    <span class="badge badge-danger">@lang('main.properties.hit')</span>
            @endif
        </div>
        <img src="{{Storage::url($product->image)}}">
        <p>{{$product->description}}</p>

        @if($product->isAvailable())
            <form action="{{route('basket-add', $product)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-success" role="button">@lang('product.add_to_cart')</button>
            </form>
        @else
            <span class="h4 text-danger">@lang('product.not_available')</span>
            <br>
            <br>
            <span>@lang('product.tell_me'):</span>

            <form method="POST" action="{{ route('subscription', $product) }}">
                @csrf
                <input type="text" name="email"></input>
                <button type="submit">@lang('product.subscribe')</button>
            </form>
            <div class="warning text-danger">
                @if($errors->get('email'))
                    {!! $errors->get('email')[0] !!}
                @endif
            </div>
        @endif

@endsection
