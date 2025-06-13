<?php
namespace Victorfreire\Contacts\Core;

use PDO;
use Victorfreire\Contacts\Core\Database;

abstract class AbstractContactModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    abstract protected function getTableName(): string;

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->getTableName());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->getTableName() . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM " . $this->getTableName() . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
