<?php

namespace Victorfreire\Contacts\Services;

use Resend;

class EmailService
{
    public function send(string $to, string $subject, string $text, string $from = 'Contact App <teste@mail.geekapps.com.br>'): bool
    {
        $resend = Resend::client('re_VJUumwew_Bn5U4xdvr4a1KJp2Va6yhhvq');
        try {
            $resend->emails->send([
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'text' => $text,
            ]);

            return true;
        } catch (\Throwable $e) {
            error_log('Erro ao enviar e-mail: ' . $e->getMessage());
            return false;
        }
    }
}
