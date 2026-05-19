<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail; // Mail facade'i eklendi
use App\Mail\MailtrapApiTransport;   // Kendi yazdığımız sınıf eklendi

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Mail::extend('mailtrap', function (array $config = []) {
            return new MailtrapApiTransport();
        });

        // Bütün .env ayarlarını ezip zorla Mailtrap API'yi seçtiriyoruz
        config(['mail.default' => 'mailtrap']);
        config(['queue.default' => 'sync']);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}