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
    <form action="register.php" method="post">
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
        <input type="submit">
    </form>
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

        header("Location:/user.php");
    }
    ?>
</body>

</html>