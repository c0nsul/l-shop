<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">Новинка</span>
            @endif

            @if($product->isRecommend())
                <span class="badge badge-warning">Рекомендуем</span>
            @endif

            @if($product->isHit())
                <span class="badge badge-danger">Хит продаж!</span>
            @endif
        </div>
        <img src="{{Storage::url($product->image)}}" alt="{{$product->name}}">
        <div class="caption">
            <h5>{{isset($category) ? $category->code : $product->Category->code}}</h5>
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} rub.</p>
            <p>
                <form action="{{route('basket-add', $product)}}" method="post">
                @csrf

                    @if($product->isAvailable())
                        <button type="submit" class="btn btn-primary" role="button">Add to basket</button>
                    @else
                        Not available
                    @endif

                    <a href="{{ route('product', [isset($category) ? $category->code : $product->Category->code, $product->code]) }}" class="btn btn-default" role="button">Details</a>
                </form>
            </p>
        </div>
    </div>
</div>
