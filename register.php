<?php
session_start();
include("pdo.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SQL запрос для вставки данных
    $sql = "INSERT INTO users (userID, firstName, lastName, dateOfBirth, `login`, `passwordHash`) VALUES (0,:firstName, :lastName, :dateOfBirth, :login, :passwordHash)";

    // Подготовка SQL запроса
    $stmt = $pdo->prepare($sql);

    // Данные для вставки
    $name = $_POST["firstName"];
    $lname = $_POST["lastName"];
    $date = $_POST["dateOfBirth"];
    $login = $_POST["login"];
    $password = $_POST["password"];

    // логин уже существует
    if (get_user($login) != null) {
        header("Location:/register.php");
        exit();
    }

    if (strlen($name) == 0 || strlen($name) > 50) {
        header("Location:/register.php");
        exit();
    }
    if (strlen($lname) == 0 || strlen($lname) > 50) {
        header("Location:/register.php");
        exit();
    }

    // Привязка параметров и выполнение запроса
    var_dump($stmt->execute(['firstName' => $name, 'lastName' => $lname, 'dateOfBirth' => $date, 'login' => $login, 'passwordHash' => password_hash($password, PASSWORD_DEFAULT)]));
    $_SESSION["login"] = $login;
    echo "Данные успешно вставлены!";

    header("Location:/user.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("header.php");
    ?>
    <form class="sign-form" action="" method="post">
        <label for="firstName">First Name</label>
        <br>
        <input type="text" name="firstName" id="firstName">
        <br>
        <label for="lastName">Last Name</label>
        <br>
        <input type="text" name="lastName" id="lastName">
        <br>
        <label for="dateOfBirth">Date of birth</label>
        <br>
        <input type="date" name="dateOfBirth" id="dateOfBirth">
        <br>
        <label for="login">Login</label>
        <br>
        <input type="text" name="login" id="login">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="register">
    </form>
</body>

</html>