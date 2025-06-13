<?php
namespace Victorfreire\Contacts\Controllers;

use Victorfreire\Contacts\Models\Contact;

class ContactController
{
    private Contact $model;

    public function __construct()
    {
        $this->model = new Contact();
    }

    public function index(): void
    {
        $contacts = $this->model->getAll();
        header('Content-Type: application/json');
        echo json_encode($contacts);
    }

    public function show(int $id): void
    {
        $contact = $this->model->findById($id);
        header('Content-Type: application/json');
        echo json_encode($contact ?: ['error' => 'Contato não encontrado']);
    }

    public function store(array $data): void
    {
        $success = $this->model->create($data);
        echo json_encode(['success' => $success]);
    }

    public function update(int $id, array $data): void
    {
        $success = $this->model->update($id, $data);
        echo json_encode(['success' => $success]);
    }

    public function delete(int $id): void
    {
        $success = $this->model->delete($id);
        echo json_encode(['success' => $success]);
    }
}
