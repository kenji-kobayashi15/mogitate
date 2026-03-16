@extends('layouts.app')

@section('title', $product->name . 'の詳細')

@section('content')
<div class="product-detail">
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 300px;">

    <h1>{{ $product->name }}</h1>
    <p>価格: {{ $product->price }}円</p>
    <p>季節:
        @foreach($product->seasons as $season)
        <span>{{ $season->name }}</span>
        @endforeach
    </p>

    {{-- 商品説明 --}}
    <div class="description">
        <p>{{ $product->description }}</p>
    </div>

    <a href="{{ route('products.index') }}">一覧に戻る</a>
</div>
@endsection