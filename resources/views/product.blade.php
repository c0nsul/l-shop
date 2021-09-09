@extends('layouts.master')

@section('title', 'Товар')

@section('content')
        <h5>{{$product->category->name}}</h5>
        <h1>{{$product->name}}</h1>
        <p>Price: <b>{{$product->price}} rub.</b></p>
        <img src="/storage/categories/{{$category->code}}.jpg">
        <p>{{$product->description}}</p>
        <form action="{{route('basket-add', $product)}}" method="post">
            @csrf
            <button type="submit" class="btn btn-success" role="button">Add to basket</button>
        </form>
@endsection
