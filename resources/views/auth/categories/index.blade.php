@extends('auth.layouts.master')

@section('title', 'Категории')

@section('content')
    <div class="col-md-12">
        <h1>Categories</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Code
                </th>
                <th>
                    Name
                </th>
                <th>
                    Actions
                </th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->code }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete category?');">
                                <a class="btn btn-success" type="button" href="{{ route('categories.show', $category) }}">Open</a>
                                <a class="btn btn-warning" type="button" href="{{ route('categories.edit', $category) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Delete"></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" type="button"
           href="{{ route('categories.create') }}">Add new category</a>
    </div>
@endsection
