<?php
namespace Victorfreire\Contacts\Controllers;

use Victorfreire\Contacts\Models\Interaction;

class InteractionController
{
    private Interaction $model;

    public function __construct()
    {
        $this->model = new Interaction();
    }

    public function index(int $contactId): void
    {
        $interactions = $this->model->getAllByContactId($contactId);
        header('Content-Type: application/json');
        echo json_encode($interactions);
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
