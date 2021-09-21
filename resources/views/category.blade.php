@extends('layouts.master')

@section('title', __('main.category') . $category->name)

@section('content')
    <h1>
        {{$category->__('name')}}
    </h1>
    <h4>({{$category->products->count()}} items)</h4>
    <p>
        {{ $category->__('description') }}
    </p>
    <div class="row">
        @foreach($category->products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
@endsection
