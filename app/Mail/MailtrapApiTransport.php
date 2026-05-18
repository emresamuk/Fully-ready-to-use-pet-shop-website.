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
        $email = Email::fromDataType($message->getOriginalMessage());
        
        // Alıcı e-posta adresini alıyoruz
        $toEmails = [];
        foreach ($email->getTo() as $address) {
            $toEmails[] = ['email' => $address->getAddress()];
        }

        // Mailtrap API token ve inbox id bilgilerini çekiyoruz
        $apiKey = env('MAILTRAP_API_KEY');
        $inboxId = env('MAILTRAP_INBOX_ID', '3190458'); // Varsayılan olarak senin id kalsın

        // İstek port engeline takılmadan standart HTTPS (443) üzerinden Mailtrap'e uçuyor
        Http::withToken($apiKey)
            ->timeout(10)
            ->post("https://sandbox.api.mailtrap.io/api/send/{$inboxId}", [
                'from' => [
                    'email' => 'info@droolpetshop.com',
                    'name' => 'Drool Pet Shop'
                ],
                'to' => $toEmails,
                'subject' => $email->getSubject(),
                'html' => $email->getHtmlBody() ?? $email->getTextBody(),
            ]);
    }

    public function __toString(): string
    {
        return 'mailtrap';
    }
}