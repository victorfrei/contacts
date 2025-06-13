<?php
namespace Victorfreire\Contacts\Models;

use Victorfreire\Contacts\Core\AbstractContactModel;
use PDO;

class Interaction extends AbstractContactModel
{
    protected function getTableName(): string
    {
        return 'interactions';
    }

    public function getAllByContactId(int $contactId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM interactions WHERE contact_id = ?");
        $stmt->execute([$contactId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO interactions (contact_id, date, type, description)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['contact_id'],
            $data['date'],
            $data['type'],
            $data['description']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE interactions
            SET date = ?, type = ?, description = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['date'],
            $data['type'],
            $data['description'],
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM interactions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
