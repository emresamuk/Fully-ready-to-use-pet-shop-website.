<?php

namespace App\Mail;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

class MailtrapApiTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        // Orijinal mesajı doğrudan çekiyoruz (Hata veren fromDataType silindi)
        /** @var Email $email */
        $email = $message->getOriginalMessage();
        
        $toEmails = [];
        foreach ($email->getTo() as $address) {
            $toEmails[] = ['email' => $address->getAddress()];
        }

        $apiKey = env('MAILTRAP_API_KEY');
        $inboxId = env('MAILTRAP_INBOX_ID'); 

        // API'ye isteği gönderiyoruz
        $response = Http::withToken($apiKey)
            ->timeout(10)
            ->post("https://sandbox.api.mailtrap.io/api/send/{$inboxId}", [
                'from' => [
                    'email' => 'info@droolpetshop.com',
                    'name' => 'Drool Pet Shop'
                ],
                'to' => $toEmails,
                'subject' => $email->getSubject(),
                'html' => $email->getHtmlBody() ?? 'Bu mail HTML desteklemiyor.',
                'text' => $email->getTextBody() ?? 'Şifre sıfırlama talebiniz alındı.',
            ]);

        // EĞER MAİLTRAP İSTEĞİ REDDEDERSE HATAYI EKRANA BASIYORUZ
        if ($response->failed()) {
            throw new \Exception('Mailtrap API Reddedildi! Durum Kodu: ' . $response->status() . ' | Sebep: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'mailtrap';
    }
}