@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<div class="page-header">
    <h1>商品一覧</h1>
    <a href="{{ route('products.create') }}" class="btn btn-orange">+ 商品を追加</a>
</div>

{{-- レイアウト全体を囲むコンテナ --}}
<div class="main-container">

    {{-- 左側：検索・並び替えエリア --}}
    <div class="sidebar">
        <form action="{{ route('products.index') }}" method="GET">
            {{-- 1. 商品名検索 --}}
            <div class="form-group">
                <label>商品名で検索</label>
                <input type="text" name="keyword" placeholder="商品名を入力" value="{{ request('keyword') }}">
                <button type="submit" class="btn-search">検索</button>
            </div>

            {{-- 2. 並び替え --}}
            <div class="form-group">
                <label>価格順で表示</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="">価格で並び替え</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>価格の安い順</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>価格の高い順</option>
                </select>
            </div>
        </form>

        {{-- 現在の検索・並び替え条件（チップ） --}}
        <div class="active-filters">
            @if(request()->filled('keyword'))
            <div class="filter-chip">
                <span>「{{ request('keyword') }}」で検索</span>
                <a href="{{ route('products.index', request()->except('keyword')) }}" class="filter-clear">×</a>
            </div>
            @endif

            @if(request()->filled('sort'))
            <div class="filter-chip">
                <span>
                    @if(request('sort') == 'asc') 価格の安い順
                    @elseif(request('sort') == 'desc') 価格の高い順
                    @endif
                </span>
                <a href="{{ route('products.index', request()->except('sort')) }}" class="filter-clear">×</a>
            </div>
            @endif
        </div>
    </div>

    {{-- 右側：商品一覧エリア --}}
    <div class="product-list-section">
        <div class="product-container">
            @foreach ($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product->id) }}" class="product-link">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p>¥{{ $product->price }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="pagination">
            {{ $products->links('vendor.pagination.default') }}
        </div>
    </div>

</div>
@endsection