{{-- 送信メール一覧 --}}
<div class="notice-mail">
    <h3 class="notice-mail__title">{{ $title }}</h3>
    <div class="notice-mail__section">
        <div class="notice-mail__submit-btn">
            <a href="{{ $createRoute }}" class="submit-btn">新規作成</a>
        </div>

        @if ($notices->isNotEmpty())
            <ul class="notice-mail__list">
                @foreach ($notices as $notice)
                    <li class="notice-mail__item">
                        <a href="{{ route($showRoute, $notice->id) }}" class="notice-mail__link">
                            <div class="notice-mail__row">
                                <div class="notice-mail__date">
                                    <img src="{{ asset('images/icon/email.png') }}" alt="Email Icon" class="icon">
                                    {{ $notice->created_at->format('Y/m/d H:i') }}
                                </div>
                                <div class="notice-mail__subject">{{ $notice->subject }}</div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="empty-message">お知らせは送信されていません</p>
        @endif

        <div class="pagination">
            {{ $notices->appends(request()->except('notices_page'))->links() }}
        </div>
    </div>
</div>