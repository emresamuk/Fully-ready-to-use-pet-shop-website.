<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Bütün önbellekleri ve .env ayarlarını ezip zorla Mailtrap API'yi seçtiriyoruz
        config(['mail.default' => 'mailtrap']);
    
        // Kuyruk sistemini ezip mailleri veritabanında bekletmeden anında göndertiyoruz
        config(['queue.default' => 'sync']);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}