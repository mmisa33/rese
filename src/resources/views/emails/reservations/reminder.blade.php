@component('mail::message')
# 【Rese】本日のご予約のご案内（{{ $reservation->shop->name }}）

{{ $reservation->user->name }} 様

いつもご利用ありがとうございます。  
本日、以下の内容でご予約を承っておりますので、改めてご案内いたします。

---

**📅 日付：** {{ \Carbon\Carbon::parse($reservation->date)->format('Y年n月j日') }}（本日）  
**🕒 時間：** {{ $reservation->time }}〜  
**👥 人数：** {{ $reservation->number }}名様  
**🏠 店舗名：** {{ $reservation->shop->name }}  
**📍 エリア：** {{ $reservation->shop->area->name }}  
**🍽 ジャンル：** {{ $reservation->shop->genre->name }}

---

@component('mail::button', ['url' => route('shop.show', ['shop_id' => $reservation->shop->id])])
▶ 店舗情報を確認する
@endcomponent

ご来店を心よりお待ちしております。  
お気をつけてお越しくださいませ。

---

Rese運営チーム
@endcomponent