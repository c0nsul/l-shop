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
        <form action="{{route('basket-add', $product)}}" method="post">
            @csrf
            @if($product->isAvailable())
                <button type="submit" class="btn btn-success" role="button">Add to basket</button>
            @else
                Not available
            @endif
        </form>
@endsection
