@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<h1>商品一覧</h1>

{{-- レイアウト全体を囲むコンテナ --}}
<div class="main-container">

    {{-- 左側：検索・並び替えエリア --}}
    <aside class="sidebar">
        <form action="{{ route('products.index') }}" method="GET">
            <div>
                <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
            </div>

            <div>
                <button type="submit">検索</button>
            </div>

            <p>価格順で表示</p>
            <div>
                <select name="sort">
                    <option value="">価格で並び替え</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>低い順に表示</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
                </select>
                <a href="{{ route('products.index') }}">×</a>
            </div>
        </form>
    </aside>

    {{-- 右側：商品一覧エリア --}}
    <div class="product-list-section">
        <div class="product-container">
            @foreach ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="product-link">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>¥{{ $product->price }}</p>
                </div>
            </a>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection