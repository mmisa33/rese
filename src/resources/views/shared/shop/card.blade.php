{{-- 共通ショップカードパーツ --}}
<div class="shop__card">
    {{-- イメージ画像 --}}
    <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" class="shop__card-image">

    <div class="shop__card-body">
        {{-- 飲食店名 --}}
        <h3 class="shop__card-title">
            {{ $shop->name }}
        </h3>

        {{-- タグ --}}
        <p class="shop__card-tags">
            <span>#{{ $shop->area->name }}</span>
            <span>#{{ $shop->genre->name }}</span>
        </p>

        {{-- 詳細ボタン --}}
        <div class="shop__card-actions">
            <div class="shop__details-btn">
                <a href="{{ route('shop.show', ['shop_id' => $shop->id]) }}" class="shop__details-btn--submit">詳しくみる</a>
            </div>

            {{-- いいねボタン --}}
            <div class="shop__like-btn">
                @auth
                    <form method="POST" action="{{ route('shop.like', ['shop_id' => $shop->id]) }}" class="shop__like-form">
                        @csrf
                        <button type="submit" class="shop__like-button">
                            @if (auth()->user()->likes->contains('id', $shop->id))
                                <i class="fa-solid fa-heart liked"></i>
                            @else
                                <i class="fa-solid fa-heart not-liked"></i>
                            @endif
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="shop__like-button">
                        <i class="fa-solid fa-heart not-liked"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>