@extends('layouts.master')

@section('title', 'Товар')

@section('content')
        <h5>{{$product->category->name}}</h5>
        <h1>{{$product->name}}</h1>
        <p>Price: <b>{{$product->price}} rub.</b></p>
        <img src="/storage/categories/{{$category->code}}.jpg">
        <p>{{$product->description}}</p>
        <a class="btn btn-success" href="/basket/1/add">Add to basket</a>
@endsection
