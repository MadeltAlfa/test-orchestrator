<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Setel Ulang Kata Sandi - GetPosition')
                ->view('emails.reset-password', [
                    'url' => $url,
                    'user' => $notifiable,
                    'count' => config('auth.passwords.'.config('auth.defaults.passwords', 'users').'.expire', 60),
                ]);
        });
    }

    // public function boot(): void
    // {
    //     // Paksa HTTPS jika request berasal dari Cloudflare Tunnel / HTTPS header
    //     if (request()->header('x-forwarded-proto') === 'https' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    //         URL::forceScheme('https');
    //     }
    // }
}
