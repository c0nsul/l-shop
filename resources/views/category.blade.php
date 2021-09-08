@extends('layouts.master')

@section('title', 'Category ' . $category->name)

@section('content')
    <h1>
        {{$category->name}}
    </h1>
    <h4>({{$category->products->count()}} items)</h4>
    <p>
        {{ $category->description }}
    </p>
    <div class="row">
        @foreach($category->products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
@endsection
