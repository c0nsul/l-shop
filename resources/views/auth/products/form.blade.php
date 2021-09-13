@extends('auth.layouts.master')

@isset($product)
    @section('title', 'Edit product ' . $product->name)
@else
    @section('title', 'Add new product')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($product)
            <h1>Edit product <b>"{{ $product->name }}"</b></h1>
        @else
            <h1>Add new product</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
              action="{{ route('products.update', $product) }}"
              @else
              action="{{ route('products.store') }}"
            @endisset
        >
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Code: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="code" id="code"
                               value="@isset($product){{ $product->code }}@endisset">

                        @include('auth.layouts.error', ['fieldName' => 'code'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($product){{ $product->name }}@endisset">

                        @include('auth.layouts.error', ['fieldName' => 'name'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Category: </label>
                    <div class="col-sm-6">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option
                                    @isset($product)
                                        @if ($category->id == $product->category_id) selected @endif
                                    @endisset
                                    value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description: </label>
                    <div class="col-sm-6">
								<textarea name="description" id="description" cols="72"
                                          rows="7">@isset($product){{ $product->description }}@endisset</textarea>

                        @include('auth.layouts.error', ['fieldName' => 'description'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-default btn-file">
                            Upload <input type="file" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Price: </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="price" id="price"
                               value="@isset($product){{ $product->price }}@endisset">

                        @include('auth.layouts.error', ['fieldName' => 'price'])
                    </div>
                </div>
                <br>
                    @foreach([
                        'hit' => 'Hit',
                        'new' => 'New',
                        'recommend' => 'Recommend'
                    ] as $field => $title)
                        <div class="input-group row">
                            <label for="code" class="col-sm-2 col-form-label">{{$title}}: </label>
                            <div class="col-sm-6">
                                <input type="checkbox" name="{{$field}}" id="{{$field}}"
                                       @if(isset($product) && $product->$field === 1)
                                            checked="checked"
                                       @endif
                                >
                            </div>
                        </div>
                    @endforeach
                    <br/>
                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
@endsection
