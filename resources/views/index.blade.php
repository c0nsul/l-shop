@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <h1>All goods</h1>

    <div class="row">
        @foreach($products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
@endsection
