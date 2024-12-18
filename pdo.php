<?php
// Настройки подключения к базе 
$host = 'localhost';
$db   = 'chat';
$pass = 'root';
$charset = 'utf8mb4';

// Настройка DSN (Data Source Name)

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции для PDO

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true,
];

try {
    // Создание нового PDO объекта (подключение к базе данных)
    $pdo = new PDO($dsn, 'root', $pass, $options);
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
    if (count($results) == 1) {
        return $results[0];
    } else {
        return NULL;
    }
}

function delete_chat($user1, $user2)
{
    global $pdo;
    $sql = "DELETE FROM chats WHERE ((user1 = :user1 AND user2 = :user2) OR (user1 = :user2 AND user2 = :user1))";

    $stmt = $pdo->prepare($sql);

    // Привязка параметров и выполнение запроса
    $stmt->execute(['user1' => $user1, 'user2' => $user2]);
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
function add_message($user1, $user2, $chatId)
{
    global $pdo;
    $sql = "SELECT MAX(messageID) FROM messages WHERE  ((userTo = :user1 AND userFrom = :user2) OR (userTo = :user2 AND userFrom = :user1)) AND chatID = :chatId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['chatId' => $chatId, 'user1' => $user1, 'user2' => $user2]);
    $results = $stmt->fetchAll();

    if (count($results) > 0) {
        $messageId = $results[0]['MAX(messageID)'] + 1;
    } else {
        $messageId = 0;
    }

    $sql = "INSERT INTO messages (messageID,chatID,message,userFrom,userTo) VALUES (:messageId,:chatId,:message,:user1,:user2);";
    $stmt = $pdo->prepare($sql);
    $message = $_POST["text"];
    $stmt->execute(['messageId' => $messageId, 'chatId' => $chatId, 'message' => $message, 'user1' => $user1, 'user2' => $user2]);
}
function get_messages($user1, $user2, $chatId)
{
    global $pdo;
    $sql = "SELECT * FROM messages WHERE  ((userTo = :user1 AND userFrom = :user2) OR (userTo = :user2 AND userFrom = :user1))";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user1' => $user1, 'user2' => $user2]);
    $results = $stmt->fetchAll();
    return $results;
}

function get_user($login)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login' => $login]);
    $results = $stmt->fetchAll();
    if (count($results) == 1) {
        return $results[0];
    } else {
        return NULL;
    }
}

function update_user($login, $name, $lname, $date)
{
    global $pdo;
    $sql = "UPDATE users SET firstName=:firstName,lastName=:lastName,dateOfBirth=:dateOfBirth  WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'firstName' => $name,
        'lastName' => $lname,
        'dateOfBirth' => $date,
        'login' => $login
    ]);
}

function get_chats_for_user($login)
{
    global $pdo;
    $sql = "SELECT * FROM chats WHERE user1 = :login or user2 =:login";

    $stmt = $pdo->prepare($sql);

    // Привязка параметров и выполнение запроса
    $stmt->execute(["login" => $login]);

    $results = $stmt->fetchAll();
    return $results;
}

if (isset($_SESSION["login"])) {
    $user = get_user($_SESSION["login"]);
}
