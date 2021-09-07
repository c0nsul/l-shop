@extends('master')

@section('title', 'Home')

@section('content')
    <div class="starter-template">
        <h1>All goods</h1>

        <div class="row">
            @foreach($products as $product)
                @include('card', compact('product'))
            @endforeach
        </div>
    </div>
@endsection
