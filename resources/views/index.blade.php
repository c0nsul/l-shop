@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <h1>All products</h1>

    <form method="GET" action="{{route("index")}}" style="margin-top: 50px">
        <div class="filters row">
            <div class="col-sm-6 col-md-3">
                <label for="price_from">Price from
                    <input type="text" name="price_from" id="price_from" size="6" value="{{ request()->price_from}}">
                </label>
                <label for="price_to">to
                    <input type="text" name="price_to" id="price_to" size="6"  value="{{ request()->price_to }}">
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="hit">
                    <input type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> Hit
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="new">
                    <input type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif> New
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="recommend">
                    <input type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif> Recommend
                </label>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route("index") }}" class="btn btn-warning">Reset</a>
            </div>
        </div>
    </form>

    <div class="row" style="margin-top: 50px">
        @foreach($products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
    {{ $products->links() }}
@endsection
