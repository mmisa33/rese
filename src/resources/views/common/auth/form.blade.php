{{-- ログイン・ユーザー登録共通レイアウト --}}
<div class="auth-form__inner">
    <div class="auth-form__header">{{ $headerText }}</div>

    <form action="{{ route($route) }}" method="POST" novalidate class="auth-form__form">
        @csrf

        @if($hasName ?? false)
        {{-- 名前入力 --}}
        <div class="auth-form__group">
            <label for="name" class="auth-form__label">
                <img src="{{ asset('images/icon/user.png') }}" alt="User Icon" class="icon">
            </label>
            <div class="auth-form__field">
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ $namePlaceholder ?? 'Username' }}" class="auth-form__input">
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @endif

        {{-- メールアドレス入力 --}}
        <div class="auth-form__group">
            <label for="email" class="auth-form__label">
                <img src="{{ asset('images/icon/email.png') }}" alt="Email Icon" class="icon">
            </label>
            <div class="auth-form__field">
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" class="auth-form__input">
                @error('email')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- パスワード入力 --}}
        <div class="auth-form__group">
            <label for="password" class="auth-form__label">
                <img src="{{ asset('images/icon/password.png') }}" alt="Password Icon" class="icon">
            </label>
            <div class="auth-form__field">
                <input type="password" name="password" id="password" placeholder="Password" class="auth-form__input">
                @error('password')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ボタン --}}
        <div class="auth-form__btn">
            <input type="submit" value="{{ $buttonText }}" class="auth-form__btn--submit">
        </div>
    </form>
</div>