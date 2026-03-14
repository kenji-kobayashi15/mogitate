{{-- resources/views/products/index.blade.php --}}
<h1>商品一覧</h1>

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    @foreach ($products as $product)
    <div style="border: 1px solid #ccc; padding: 15px; width: 250px;">
        {{-- 画像 --}}
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%;">

        <h3>{{ $product->name }}</h3>
        <p>価格: {{ $product->price }}円</p>
        <p>季節:
            @foreach($product->seasons as $season)
            {{ $season->name }}
            @endforeach
        </p>
    </div>
    @endforeach
</div>

{{-- ページネーションリンク --}}
<div style="margin-top: 20px;">
    {{ $products->links() }}
</div>