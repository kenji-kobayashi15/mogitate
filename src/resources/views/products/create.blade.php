@extends('layouts.app')

@section('content')
<main>
    <h2>商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="registration-form">
        @csrf

        {{-- 商品名 --}}
        <div class="form-group">
            <label>商品名 <span class="label-required">必須</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        {{-- 値段 --}}
        <div class="form-group">
            <label>値段 <span class="label-required">必須</span></label>
            <input type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        {{-- 商品画像（方法A：標準ボタンに変更） --}}
        <div class="form-group">
            <label>商品画像 <span class="label-required">必須</span></label>
            <div class="file-input-container">
                <input type="file" name="image" id="image-upload">
            </div>
            @error('image') <p class="error-text" style="color:red;">{{ $message }}</p> @enderror
        </div>

        {{-- 季節 --}}
        <div class="form-group">
            <div class="label-row">
                <label>季節 <span class="label-required">必須</span></label>
                <span class="text-note-red">複数選択可</span>
            </div>
            <div class="checkbox-group">
                @foreach(['春', '夏', '秋', '冬'] as $index => $seasonName)
                <label class="checkbox-label">
                    <input type="checkbox" name="seasons[]" value="{{ $index + 1 }}"
                        {{ (is_array(old('seasons')) && in_array($index + 1, old('seasons'))) ? 'checked' : '' }}>
                    {{ $seasonName }}
                </label>
                @endforeach
            </div>
            @error('seasons') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label>商品説明 <span class="label-required">必須</span></label>
            <textarea name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="button-group">
            <a href="{{ route('products.index') }}" class="btn btn-gray">戻る</a>
            <button type="submit" class="btn btn-orange">登録</button>
        </div>
    </form>
</main>
@endsection