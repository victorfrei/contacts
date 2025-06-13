<?php
require_once __DIR__ . '/../vendor/autoload.php';

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use Victorfreire\Contacts\Controllers\ContactController;
use Victorfreire\Contacts\Controllers\InteractionController;
use Victorfreire\Contacts\Controllers\SendEmailController;
use Victorfreire\Contacts\Controllers\UploadController;

$controller = new ContactController();
$interactionController = new InteractionController();

$uploadController = new UploadController();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];


switch ("$method $uri") {
    case 'GET /':
        readfile(__DIR__ . '/index.html');
        break;

    case 'GET /contacts':
        $controller->index();
        break;

    case (str_starts_with("$method $uri", 'GET /contact/')):
        $controller->show((int) basename($uri));
        break;

    case 'POST /contact':
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->store($data);
        break;

    case (str_starts_with("$method $uri", 'PUT /contact/')):
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->update((int) basename($uri), $data);
        break;

    case (str_starts_with("$method $uri", 'DELETE /contact/')):
        $controller->delete((int) basename($uri));
        break;

    case 'GET /interactions':
        $contactId = (int) basename($uri);
        $interactionController->index($contactId);
        break;

    case "$method $uri" === 'POST /interactions':
        $data = json_decode(file_get_contents('php://input'), true);
        $interactionController->store($data);
        break;

    case str_starts_with("$method $uri", 'PUT /interactions/'):
        $id = (int) basename($uri);
        $data = json_decode(file_get_contents('php://input'), true);
        $interactionController->update($id, $data);
        break;

    case str_starts_with("$method $uri", 'DELETE /interactions/'):
        $id = (int) basename($uri);
        $interactionController->delete($id);
        break;

    case 'POST /send-email':
        $controller = new SendEmailController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->send($data);
        break;

    case 'POST /upload':
        $uploadController->handle();
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
}
