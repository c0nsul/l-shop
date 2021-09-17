<p>Hello {{ $name }}</p>

<p>Your order is created! Your total payment: {{ $fullSum }} rub</p>

<table>
    <tbody>
    @foreach($order->products as $product)
        <tr>
            <td>
                <a href="{{ route('product', [$product->category->code, $product->code]) }}">
                    <img height="56px" src="{{ Storage::url($product->image) }}">
                    {{ $product->name }}
                </a>
            </td>
            <td><span class="badge">{{ $product->pivot->count }}</span>
                <div class="btn-group form-inline">
                    {!! $product->description !!}
                </div>
            </td>
            <td>{{ $product->price }} rub.</td>
            <td>{{ $product->getPriceForCount() }} rub.</td>
        </tr>
    @endforeach
    </tbody>
</table>
