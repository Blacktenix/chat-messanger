<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include("header.php");
    ?>
    <h1>First Name:<?php echo htmlspecialchars($_POST["firstName"]) ?></h1>
    <h1>Last Name:<?php echo htmlspecialchars($_POST["lastName"]) ?></h1>
    <h1>Date of birth:<?php echo htmlspecialchars($_POST["dateOfBirth"]) ?></h1>
    <h1>Login:<?php echo htmlspecialchars($_POST["login"]) ?></h1>
    <h1>Password:<?php echo htmlspecialchars($_POST["password"]) ?></h1>
    <?php
    // Настройки подключения к базе данных
    include("pdo.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // SQL запрос для вставки данных
        $sql = "INSERT INTO users (firstName, lastName, dateOfBirth, `login`, `password`) VALUES (:firstName, :lastName, :dateOfBirth, :login, :password)";

        // Подготовка SQL запроса
        $stmt = $pdo->prepare($sql);

        // Данные для вставки
        $name = $_POST["firstName"];
        $lname = $_POST["lastName"];
        $date = $_POST["dateOfBirth"];
        $login = $_POST["login"];
        $password = $_POST["password"];

        $_SESSION["login"] = $login;
        $_SESSION["password"] = $password;

        // Привязка параметров и выполнение запроса
        var_dump($stmt->execute(['firstName' => $name, 'lastName' => $lname, 'dateOfBirth' => $date, 'login' => $login, 'password' => $password]));
        $_SESSION["id"] = $pdo->lastInsertId();
        echo "Данные успешно вставлены!";
    }
    ?>
</body>

</html>