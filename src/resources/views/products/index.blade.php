@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
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
    {{-- ループ文に追記(リンク部分) --}}
    <div class="product-card">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        <h3>{{ $product->name }}</h3>

        {{-- 詳細ボタンを追加 --}}
        <a href="{{ route('products.show', $product->id) }}" class="btn">詳細を見る</a>
    </div>
    @endforeach
</div>

{{-- ページネーションリンク --}}
<div style="margin-top: 20px;">
    {{ $products->links() }}
</div>
@endsection