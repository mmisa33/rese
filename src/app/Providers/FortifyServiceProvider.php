<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Actions\Fortify\CustomLoginResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);

        // 会員登録後にプロフィールサンクスページへリダイレクト
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                // 登録後に自動ログインされていたらログアウト
                Auth::logout();

                // セッションの再生成
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->view('auth.thanks');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログインページの表示
        Fortify::loginView(function (Request $request) {
            return $request->is('admin/*')
                ? view('admin.auth.login')
                : view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // LoginRequestのバリデーションを使用
        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);
    }
}
