{{-- 季節チェックボックス共通パーツ --}}
<div class="form-group">
    <div class="label-row">
        <label>季節 <span class="label-required">必須</span></label>
        <span class="text-note-red">複数選択可</span>
    </div>
    <div class="checkbox-group">
        @foreach(['春', '夏', '秋', '冬'] as $index => $seasonName)
        @php $seasonId = $index + 1; @endphp
        <label class="checkbox-label">
            <input type="checkbox" name="seasons[]" value="{{ $seasonId }}"
                {{ (is_array(old('seasons')) && in_array($seasonId, old('seasons')))
                    || (!old('seasons') && isset($product) && $product->seasons->contains('id', $seasonId))
                    ? 'checked' : '' }}>
            {{ $seasonName }}
        </label>
        @endforeach
    </div>
    @error('seasons')
    <p class="error-text">{{ $message }}</p>
    @enderror
</div>