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
</body>

</html>