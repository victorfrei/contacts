<?php

namespace Victorfreire\Contacts\Controllers;

use Victorfreire\Contacts\Services\EmailService;

class SendEmailController
{
    private EmailService $emailService;

    public function __construct()
    {
        $this->emailService = new EmailService();
    }

    public function send(array $data): void
    {
        $to = $data['to'] ?? null;
        $subject = $data['subject'] ?? 'Sem assunto';
        $message = $data['message'] ?? '';

        if (!$to || !$message) {
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios: to e message']);
            return;
        }

        $success = $this->emailService->send($to, $subject, $message);

        if ($success) {
            echo json_encode(['status' => 'E-mail enviado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao enviar e-mail']);
        }
    }
}
