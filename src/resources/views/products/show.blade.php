@extends('layouts.app')

@section('content')
<form id="update-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="detail-container">
        <nav class="breadcrumb">
            <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
        </nav>
        {{-- 左側：画像エリア --}}
        <div class="image-section">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 300px;">
            <label class="btn-file-select custom-file-width">
                ファイルを選択
                <input type="file" name="image" style="display:none;">
            </label>
        </div>

        {{-- 右側：基本情報エリア --}}
        <div class="info-section">
            {{-- 商品名 --}}
            <div>
                <label>商品名</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}">
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            {{-- 値段 --}}
            <div>
                <label>値段</label>
                <input type="text" name="price" value="{{ old('price', $product->price) }}">
                @error('price') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            {{-- 季節（info-sectionの中へ移動） --}}
            <div>
                <label>季節</label>
                {{-- ★ここに class="checkbox-group" を追加します★ --}}
                <div class="checkbox-group">
                    @foreach(['春', '夏', '秋', '冬'] as $index => $seasonName)
                    @php $seasonId = $index + 1; @endphp
                    {{-- ★ここを <label class="checkbox-label"> で囲むと綺麗に並びます★ --}}
                    <label class="checkbox-label">
                        <input type="checkbox" name="seasons[]" value="{{ $seasonId }}"
                            {{ (is_array(old('seasons')) && in_array($seasonId, old('seasons')))
                || (!old('seasons') && $product->seasons->contains('id', $seasonId))
                ? 'checked' : '' }}>
                        {{ $seasonName }}
                    </label>
                    @endforeach
                </div>
                @error('seasons')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- 下部：商品説明エリア --}}
    <div class="description-section">
        <label>商品説明</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
        @error('description')
        <p style="color: red;">{{ $message }}</p>
        @enderror
    </div>
</form>
{{-- ボタンエリア --}}
<div class="footer-button-container">

    {{-- 中央：戻る・保存ボタン --}}
    <div class="button-group">
        <a href="{{ route('products.index') }}" class="btn btn-gray">戻る</a>
        <button type="submit" form="update-form" class="btn btn-orange">変更を保存</button>
    </div>

    {{-- 右端：削除ボタン --}}
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('本当に削除しますか？')">🗑</button>
    </form>
</div>

@endsection