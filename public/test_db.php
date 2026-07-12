<?php
header('Content-Type: text/plain');

$host = $_ENV['DB_HOST'] ?? 'mysql-2c5aff20-dandyichlamsyah-3a39.d.aivencloud.com';
$port = $_ENV['DB_PORT'] ?? '24254';
$db   = $_ENV['DB_DATABASE'] ?? 'defaultdb';
$user = $_ENV['DB_USERNAME'] ?? 'avnadmin';
$pass = $_ENV['DB_PASSWORD'] ?? 'AVNS_5Io67DOwAJ4aygIB8yh';

echo "Testing direct connection to $host:$port...\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "SUCCESS: Connected to database successfully!\n";
} catch (\PDOException $e) {
    echo "ERROR: Connection failed: " . $e->getMessage() . "\n";
}
