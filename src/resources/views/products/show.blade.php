@extends('layouts.app')

@section('content')
<nav>
    <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
</nav>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    <div class="detail-container">
        {{-- 左側：画像エリア --}}
        <div class="image-section">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 300px;">
            <input type="file" name="image">
        </div>

        {{-- 右側：基本情報エリア --}}
        <div class="info-section">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
            <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        {{-- 値段 --}}
        <div>
            <label>値段</label>
            <input type="text" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
            <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        {{-- 季節 --}}
        <div>
            <label>季節</label>
            <div>
                @foreach(['春', '夏', '秋', '冬'] as $seasonName)
                <input type="checkbox" name="seasons[]" value="{{ $seasonName }}"
                    {{-- oldがあればそれを優先、なければDBの値を参照する --}}
                    {{ (is_array(old('seasons')) && in_array($seasonName, old('seasons')))
                    || (!old('seasons') && $product->seasons->contains('name', $seasonName))
                    ? 'checked' : '' }}>
                {{ $seasonName }}
                @endforeach
                @error('seasons')
                <p style="color: red;">{{ $message }}</p>
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

    {{-- ボタンエリア --}}
    <div class="button-group">
        <a href="{{ route('products.index') }}">戻る</a>
        <button type="submit">変更を保存</button>
    </div>
</form>

{{-- 削除ボタン --}}
<form action="{{ route('products.destroy', $product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('本当に削除しますか？')">🗑</button>
</form>

@endsection