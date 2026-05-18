<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Eksik olan sınıf buraya eklendi

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
    // Hangi .env değişkeni olursa olsun, SMTP motorunu koddan tamamen kapatıyoruz
    config(['mail.default' => 'log']);
    config(['mail.mailers.smtp.transport' => 'log']);

    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    Password::sendResetLinkUsing(function ($user, $token) {
        $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($user->getEmailForPasswordReset()));
        $inboxId = env('MAILTRAP_INBOX_ID', '3190458'); 
        $apiKey = env('MAILTRAP_API_KEY');

        try {
            // SMTP yerine doğrudan HTTP üzerinden Mailtrap API'ye fırlatıyoruz
            $response = Http::withToken($apiKey)
                ->timeout(10)
                ->post("https://sandbox.api.mailtrap.io/api/send/{$inboxId}", [
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
                        <p><a href="'.$resetUrl.'" style="background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;display:inline-block;">Şifremi Sıfırla</a></p>
                        <p>Eğer buton çalışmıyorsa şu linki kopyalayabilirsiniz: '.$resetUrl.'</p>
                    ',
                ]);

            if ($response->failed()) {
                Log::error('Mailtrap API Hatası: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Mail Gönderimi Sırasında İstisna Oluştu: ' . $e->getMessage());
        }
    });
}
}