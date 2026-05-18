<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
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
    // Canlı sunucuda linkleri HTTPS'e zorlamak için (Önceki adım)
    if (config('app.env') === 'production') {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }

    // Şifre sıfırlama mailini SMTP yerine doğrudan Mailtrap API üzerinden fırlatıyoruz
    Password::sendResetLinkUsing(function ($user, $token) {
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ], false));

        // Mailtrap API Endpoint (Sandbox için)
        Http::withToken(env('MAILTRAP_API_KEY'))
            ->post('https://sandbox.api.mailtrap.io/api/send/' . env('MAILTRAP_INBOX_ID', '3190458'), [
                'from' => [
                    'email' => 'info@droolpetshop.com',
                    'name' => 'Drool Pet Shop'
                ],
                'to' => [
                    ['email' => $user->getEmailForPasswordReset()]
                ],
                'subject' => 'Şifre Sıfırlama Talebi',
                'html' => '
                    <h3>Merhaba,</h3>
                    <p>Hesabınız için bir şifre sıfırlama talebi aldık. Aşağıdaki butona tıklayarak şifrenizi sıfırlayabilirsiniz:</p>
                    <a href="'.$resetUrl.'" style="background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;">Şifremi Sıfırla</a>
                    <p>Eğer bu talebi siz yapmadıysanız, bu e-postayı dikkate almayınız.</p>
                ',
            ]);
    });
}
}
