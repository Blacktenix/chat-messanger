<?php

$host = 'localhost';
$db   = 'chat';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Start the migration process
    $pdo->beginTransaction();

    // --------- КОМАНДЫ МИГРАЦИИ ------------

    // 1. Удалить пользователей с NULL значениями в любых колонках
    $pdo->exec("
        DELETE FROM users
        WHERE login IS NULL 
           OR userID IS NULL 
           OR firstName IS NULL 
           OR lastName IS NULL 
           OR dateOfBirth IS NULL 
           OR password IS NULL;
    ");

    // 2. Убрать дубликаты пользователей
    $pdo->exec("
        CREATE TEMPORARY TABLE temp_users AS
        SELECT * FROM users u1
        WHERE u1.userID = (
            SELECT u2.userID 
            FROM users u2 
            WHERE u2.login = u1.login 
            LIMIT 1
        );
    ");
    $pdo->exec("DELETE FROM users;");
    $pdo->exec("
        INSERT INTO users (userID, login, firstName, lastName, dateOfBirth, password)
        SELECT userID, login, firstName, lastName, dateOfBirth, password FROM temp_users;
    ");

    // 3. Убрать Auto Increment из users
    $pdo->exec("ALTER TABLE users MODIFY userID INT NOT NULL");

    // 4. Убрать ограничение на основной ключ
    $pdo->exec("ALTER TABLE users DROP PRIMARY KEY");

    // 5. Сделать колонку login основным ключем
    $pdo->exec("ALTER TABLE users ADD PRIMARY KEY (login)");

    // 6. Изменить тип колонок user1 и user2 в таблице chats на VARCHAR(30)
    $pdo->exec("ALTER TABLE chats MODIFY user1 VARCHAR(30), MODIFY user2 VARCHAR(30)");

    // 7. Обновить колонки user1 и user2 с логинами из users
    $pdo->exec("
        UPDATE chats
        SET user1 = (SELECT login FROM users WHERE users.userID = chats.user1),
            user2 = (SELECT login FROM users WHERE users.userID = chats.user2)
    ");

    // 8. Изменить тип колонок userTo и userFrom в таблице messages на VARCHAR(30)
    $pdo->exec("ALTER TABLE messages MODIFY userTo VARCHAR(30), MODIFY userFrom VARCHAR(30)");

    // 9. Обновить колонки userTo и userFrom с логинами из users
    $pdo->exec("
        UPDATE messages
        SET userTo = (SELECT login FROM users WHERE users.userID = messages.userTo),
            userFrom = (SELECT login FROM users WHERE users.userID = messages.userFrom)
    ");

    // 10. Удалить чаты с NULL значениями в любых колонках (чаты с удаленными пользователями)
    $pdo->exec("DELETE FROM chats WHERE user1 IS NULL OR user2 IS NULL;");

    // 11.Удалить сообщения с NULL значениями в любых колонках (сообщения с удаленными пользователями)
    $pdo->exec("DELETE FROM messages WHERE message IS NULL OR userTo IS NULL OR userFrom IS NULL;");

    // 12. Удалить колонку userID из users
    $pdo->exec("ALTER TABLE users DROP COLUMN userID");


    // ----------------------------------------

    // Commit the transaction
    $pdo->commit();

    echo "Migration completed successfully!";
} catch (PDOException $e) {
    // Rollback the transaction if something went wrong
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Migration failed: " . $e->getMessage();
}
