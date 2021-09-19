Hello sir, product {{ $product->name }} is available now.

<a href="{{ route('product', [$product->category->code, $product->code]) }}">Get more details</a>
