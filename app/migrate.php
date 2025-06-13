<?php
require_once __DIR__ . '/../vendor/autoload.php';


$config = require __DIR__ . '/src/config/config.php';
$db = $config['db'];

try {
    $pdo = new PDO(
        "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4",
        $db['user'],
        $db['pass']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "🔄 Executando migração...\n";

    $sql = file_get_contents(__DIR__ . '/../sql/general.sql');
    $pdo->exec($sql);

    echo "✅ Migração concluída com sucesso.\n";
} catch (PDOException $e) {
    echo "❌ Erro na migração: " . $e->getMessage() . "\n";
}
