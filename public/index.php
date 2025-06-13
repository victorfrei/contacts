<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Victorfreire\Contacts\Controllers\ContactController;

$controller = new ContactController();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ("$method $uri") {
    case 'GET /contacts':
        $controller->index();
        break;

    case (str_starts_with("$method $uri",'GET /contact/')):
        $controller->show((int) basename($uri));
        break;

    case 'POST /contact':
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->store($data);
        break;

    case (str_starts_with("$method $uri",'PUT /contact/')):
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->update((int) basename($uri), $data);
        break;

    case (str_starts_with("$method $uri",'DELETE /contact/')):
        $controller->delete((int) basename($uri));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
}
