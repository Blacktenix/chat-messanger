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


    //$pdo->exec("ALTER TABLE `chat`.`users` 
    //ADD COLUMN `passwordHash` VARCHAR(60) NULL AFTER `password`;");
    
    $stmt = $pdo->prepare("SELECT `password`, `login` FROM `users`");
    $stmt->execute();
    $results = $stmt->fetchAll();
    for ($i=0;$i<count($results);$i++){
        $data = $results[$i];
        $password = $data["password"];
        $login = $data["login"];
        $hash =  password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET passwordHash = :hash WHERE `login` = :login");
        $stmt->execute(["hash" => $hash, "login" => $login]);

    }   
    $pdo->exec("ALTER TABLE `chat`.`users` DROP COLUMN `password`;");

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
