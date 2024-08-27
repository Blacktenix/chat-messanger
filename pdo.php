
<?php

// Настройки подключения к базе 
$host = 'localhost';
$db   = 'chat';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

// Настройка DSN (Data Source Name)

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции для 

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true,
];

try {
    // Создание нового PDO объекта (подключение к базе данных)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Обработка ошибки подключения
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>