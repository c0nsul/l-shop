@extends('master')

@section('title', 'Home')

@section('content')
    <div class="starter-template">
        <h1>All goods</h1>

        <div class="row">
            @include('card')
        </div>
    </div>
@endsection
