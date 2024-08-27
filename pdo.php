
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

function get_chat($user1, $user2)
{
    global $pdo;
    $sql = "SELECT chatID FROM chats WHERE  ((user1 = :user1 AND user2 = :user2) OR (user1 = :user2 AND user2 = :user1))";

    $stmt = $pdo->prepare($sql);

    // Привязка параметров и выполнение запроса
    $stmt->execute(['user1' => $user1, 'user2' => $user2]);

    $results = $stmt->fetchAll();
    return $results;
}

function create_chat($user1, $user2)
{
    global $pdo;
    // SQL запрос для вставки данных
    $sql = "INSERT INTO chats (user1, user2) VALUES (:user1, :user2)";

    // Подготовка SQL запроса
    $stmt = $pdo->prepare($sql);

    // Привязка параметров и выполнение запроса
    $stmt->execute(['user1' => $user1, 'user2' => $user2]);
    $chatId = $pdo->lastInsertId();
    return $chatId;
}
?>