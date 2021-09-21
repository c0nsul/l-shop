@extends('auth.layouts.master')

@section('title', 'Product ' . $product->name)

@section('content')
    <div class="col-md-12">
        <h1>{{ $product->name }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Field
                </th>
                <th>
                    Value
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $product->id}}</td>
            </tr>
            <tr>
                <td>Code</td>
                <td>{{ $product->code }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td>Name ENG</td>
                <td>{{ $product->name_en }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <td>Description ENG</td>
                <td>{{ $product->description_en }}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    <img src="{{ Storage::url($product->image)}}" height="240px">
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <td>Attribute</td>
                <td>
                    <div class="labels">
                        @if($product->isNew())
                            <span class="badge badge-success">New</span>
                        @endif

                        @if($product->isRecommend())
                            <span class="badge badge-warning">Recomend</span>
                        @endif

                        @if($product->isHit())
                            <span class="badge badge-danger">Sales hit!</span>
                        @endif
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
@endsection
