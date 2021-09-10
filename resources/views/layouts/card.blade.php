<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <img src="{{Storage::url($product->image)}}" alt="{{$product->name}}">
        <div class="caption">
            <h5>{{$product->Category->name}}</h5>
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} rub.</p>
            <p>
                <form action="{{route('basket-add', $product)}}" method="post">
                @csrf
                    <button type="submit" class="btn btn-primary" role="button">Add to basket</button>
                    <a href="{{ route('product', [$product->Category->code, $product->code])}}" class="btn btn-default" role="button">Details</a>
                </form>
            </p>
        </div>
    </div>
</div>
