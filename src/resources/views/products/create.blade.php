@extends('layouts.app')

@section('content')
<h2>商品登録</h2>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- 商品名 --}}
    <div class="form-group">>
        <label>商品名 <span class="label-required">必須</span></label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
        @error('name') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        {{-- 値段 --}}
        <div>
            <label>値段 <span>必須</span></label>
            <input type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        {{-- 商品画像 --}}
        <div>
            <label>商品画像 <span>必須</span></label>
            <input type="file" name="image">
            @error('image') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        {{-- 季節 --}}
        <div>
            <label>季節 <span>必須</span></label>
            <div>
                {{-- 修正：$index + 1 を使って 1, 2, 3, 4 を送る --}}
                @foreach(['春', '夏', '秋', '冬'] as $index => $seasonName)
                <label>
                    <input type="checkbox" name="seasons[]" value="{{ $index + 1 }}"
                        {{ (is_array(old('seasons')) && in_array($index + 1, old('seasons'))) ? 'checked' : '' }}>
                    {{ $seasonName }}
                </label>
                @endforeach
            </div>
            @error('seasons') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        {{-- 商品説明 --}}
        <div>
            <label>商品説明 <span>必須</span></label>
            <textarea name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        {{-- 下のボタンエリア --}}
        <div class="button-group">
            <a href="{{ route('products.index') }}" class="btn btn-gray">戻る</a>
            <button type="submit" class="btn btn-orange">登録</button>
        </div>
</form>
@endsection