<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;
use Illuminate\Support\Facades\Log;

class SendReservationReminders extends Command
{
    protected $signature = 'reminder:send-reservations';
    protected $description = '予約当日のユーザーにリマインダーメールを送信する';

    public function handle()
    {
        $today = now()->format('Y-m-d');

        $reservations = Reservation::with('user', 'shop')
            ->whereDate('date', $today)
            ->get();

        foreach ($reservations as $reservation) {
            if (!$reservation->user || !$reservation->user->email) {
                Log::warning('リマインダーメール送信スキップ：ユーザー情報が不足', [
                    'reservation_id' => $reservation->id,
                ]);
                continue;
            }

            try {
                Mail::to($reservation->user->email)
                    ->send(new ReservationReminderMail($reservation));

                $this->info("送信成功: {$reservation->user->email}");
            } catch (\Throwable $e) {
                Log::error('リマインダーメール送信エラー', [
                    'email' => $reservation->user->email,
                    'error' => $e->getMessage(),
                ]);
                $this->error("送信失敗: {$reservation->user->email}");
            }
        }

        $this->info('予約リマインダーの送信が完了しました');

        // 送信完了の日時をログに残す
        Log::info('予約リマインダーメール送信完了: ' . now()->toDateTimeString());
    }
}