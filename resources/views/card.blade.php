<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <img src="/storage/products/iphone_x.jpg" alt="iPhone X 64GB">
        <div class="caption">
            <h5>{{$product->Category->name}}</h5>
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} руб.</p>
            <p>
                <a href="{{ route('basket') }}" class="btn btn-primary"
                   role="button">Add to basket</a>
                <a href="/{{ $product->Category->code}}/iphone_x_64" class="btn btn-default" role="button">Details</a>

            </p>
        </div>
    </div>
</div>
