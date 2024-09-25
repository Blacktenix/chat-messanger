<?php
session_start();
include("pdo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("header.php") ?>
    <form class="sign-form" action="" method="post">
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
            $_SESSION["id"] = $user["userID"];
            header("Location:/user.php");
        } else {
            echo "<p class=\"error\">Incorrect Login or Password</p>";
        }
    }
    ?>
</body>

</html>