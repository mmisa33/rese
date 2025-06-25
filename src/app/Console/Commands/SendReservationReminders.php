<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;

class SendReservationReminders extends Command
{
    protected $signature = 'reminder:send-reservations';

    protected $description = '予約当日のユーザーにリマインダーメールを送信する';

    public function handle()
    {
        // 今日の日付（YYYY-MM-DD）
        $today = now()->format('Y-m-d');

        // 今日の予約を取得
        $reservations = Reservation::with('user', 'shop')
            ->where('date', $today)
            ->get();

        // 予約ごとにメール送信
        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)
                ->send(new ReservationReminderMail($reservation));
        }

        $this->info('予約リマインダーの送信が完了しました');
    }
}