@extends('auth.layouts.master')

@section('title', 'Категория ' . $category->name)

@section('content')
    <div class="col-md-12">
        <h1>Category "{{$category->name}}"</h1>
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
                <td>{{ $category->id }}</td>
            </tr>
            <tr>
                <td>Code</td>
                <td>{{ $category->code }}</td>
            </tr>
            <tr>
                <td>Name(ru)</td>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <td>Name(eng)</td>
                <td>{{ $category->name_en}}</td>
            </tr>
            <tr>
                <td>Description(RU)</td>
                <td>{{ $category->description }}</td>
            </tr>
            <tr>
                <td>Description(EN)</td>
                <td>{{ $category->description_en }}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    @if(isset($category->image))
                        <img src="{{ Storage::url($category->image)}}" height="240px">
                    @else
                        no image
                    @endif
                </td>
            </tr>
            <tr>
                <td>Products counter</td>
                <td>{{ $category->products->count() }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
