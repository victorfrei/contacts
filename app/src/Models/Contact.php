<?php
namespace Victorfreire\Contacts\Models;

use Victorfreire\Contacts\Core\AbstractContactModel;
use InvalidArgumentException;


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

    public function updateFile(int $id, string $field, string $path): bool
{
    if (!in_array($field, ['profile_image', 'attachment'])) {
        throw new InvalidArgumentException("Campo inválido: $field");
    }

    $stmt = $this->db->prepare("UPDATE contacts SET {$field} = :path WHERE id = :id");
    return $stmt->execute([
        'path' => $path,
        'id' => $id
    ]);
}
}
