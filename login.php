<?php
session_start();
include("pdo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include("header.php") ?>
    <form action="user.php" method="post">
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = find_user($_POST["login"], $_POST["password"]);
        if ($user) {
            $_SESSION["login"] = $user["login"];
            $_SESSION["id"] = $user["userID"];
            $_SESSION["password"] = $user["password"];

            header("Location:/user.php");
        }
    }
    ?>
</body>

</html>