<div class="notice">
    <div class="page-title">
        <a href="{{ $back }}" class="back-btn">&lt;</a>
        <h2>お知らせメール送信</h2>
    </div>

    {{-- メール送信フォーム --}}
    <div class="notice__content">
        <form method="POST" action="{{ $action }}" class="notice-form" novalidate>
            @csrf

            {{-- フラッシュメッセージ --}}
            @if (session('success'))
                <div class="flash-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('send_error'))
                <div class="flash-message">
                    @foreach ($errors->get('send_error') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <div class="notice-form__group select-wrapper">
                <label class="notice-form__label" for="target">宛先</label>
                <select name="target" id="target" class="notice-form__select">
                    <option value="">宛先を選択</option>
                    @foreach ($oldTargets as $key => $label)
                        <option value="{{ $key }}" {{ old('target') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
            </div>
            @error('target')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="notice-form__group" id="custom-address-group" style="display: none;">
                <label class="notice-form__label" for="emails">メールアドレス</label>
                <input type="text" name="emails" id="emails" class="notice-form__input" placeholder="カンマ区切りで複数指定可" value="{{ old('emails') }}">
                <div class="form-note">例）example1@rese.com, example2@rese.com</div>
            </div>
            @error('emails')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="notice-form__group">
                <label class="notice-form__label" for="subject">件名</label>
                <input type="text" name="subject" id="subject" class="notice-form__input" value="{{ old('subject') }}">
            </div>
            @error('subject')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="notice-form__group">
                <label class="notice-form__label" for="message">本文</label>
                <textarea name="message" id="message" rows="8" class="notice-form__textarea">{{ old('message') }}</textarea>
            </div>
            @error('message')
                <p class="error-message">{{ $message }}</p>
            @enderror

            {{-- 送信ボタン --}}
            <div class="notice-form__btn">
                <button type="submit" class="notice__btn--submit">送信する</button>
            </div>
        </form>
    </div>
</div>

{{-- 手動選択時に自動的にアドレス欄を表示 --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const target = document.getElementById('target');
    const customField = document.getElementById('custom-address-group');

    function toggleCustomField() {
        customField.style.display = target.value === 'custom' ? 'block' : 'none';
    }

    target.addEventListener('change', toggleCustomField);
    toggleCustomField();
});
</script>