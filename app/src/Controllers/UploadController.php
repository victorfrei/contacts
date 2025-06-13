<?php

namespace Victorfreire\Contacts\Controllers;

use Victorfreire\Contacts\Models\Contact;

class UploadController
{
    private const IMAGE_MAX_SIZE = 2 * 1024 * 1024; // 2MB
    private const FILE_MAX_SIZE = 5 * 1024 * 1024;  // 5MB

    private const ALLOWED_IMAGES = ['image/jpeg', 'image/png'];
    private const ALLOWED_FILES = ['application/pdf', 'application/zip', 'text/plain'];

    public function handle(): void
    {
        header('Content-Type: application/json');

        if (!isset($_POST['contact_id']) || !is_numeric($_POST['contact_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID do contato não fornecido.']);
            return;
        }

        $contactId = (int) $_POST['contact_id'];
        $fileKey = array_key_first($_FILES); // 'profile' ou 'attachment'

        if (!in_array($fileKey, ['profile', 'attachment'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Campo inválido. Use "profile" ou "attachment".']);
            return;
        }

        $file = $_FILES[$fileKey];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'Erro no upload do arquivo.']);
            return;
        }

        // Validação por tipo
        if ($fileKey === 'profile') {
            if ($file['size'] > self::IMAGE_MAX_SIZE || !in_array($file['type'], self::ALLOWED_IMAGES)) {
                http_response_code(400);
                echo json_encode(['error' => 'Imagem inválida. Apenas JPEG/PNG até 2MB.']);
                return;
            }
        } elseif ($fileKey === 'attachment') {
            if ($file['size'] > self::FILE_MAX_SIZE || !in_array($file['type'], self::ALLOWED_FILES)) {
                http_response_code(400);
                echo json_encode(['error' => 'Arquivo inválido. Apenas PDF/ZIP/TXT até 5MB.']);
                return;
            }
        }

        $uploadDir = __DIR__ . '/../../../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $filename = uniqid() . '_' . basename($file['name']);
        $path = 'uploads/' . $filename;
        $fullPath = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Falha ao salvar o arquivo.']);
            return;
        }

        $contact = new Contact();
        $contact->updateFile($contactId, $fileKey === 'profile' ? 'profile_image' : 'attachment', $path);

        echo json_encode(['success' => true, 'path' => $path]);
    }
}
