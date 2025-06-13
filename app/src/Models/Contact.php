<?php
namespace Victorfreire\Contacts\Models;

use Victorfreire\Contacts\Core\AbstractContactModel;
use PDO;

class Contact extends AbstractContactModel
{
    protected function getTableName(): string
    {
        return 'contacts';
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO contacts (name, email, phone, birthdate, notes)
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['birthdate'],
            $data['notes']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE contacts SET name = ?, email = ?, phone = ?, birthdate = ?, notes = ? WHERE id = ?
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['birthdate'],
            $data['notes'],
            $id
        ]);
    }
}
