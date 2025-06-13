<?php
namespace Victorfreire\Contacts\Core;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        $config = require __DIR__ . '/../config/config.php';
        $db = $config['db'];

        try {
            $pdo = new PDO(
                "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4",
                $db['user'],
                $db['pass']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }
}
