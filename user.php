<?php
session_start();
include("pdo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("header.php");
    ?>
    <h1>First Name:<?php echo htmlspecialchars($user["firstName"]) ?></h1>
    <h1>Last Name:<?php echo htmlspecialchars($user["lastName"]) ?></h1>
    <h1>Date of birth:<?php echo htmlspecialchars($user["dateOfBirth"]) ?></h1>
    <h1>Login:<?php echo htmlspecialchars($user["login"]) ?></h1>
    <h1>Password:<?php echo htmlspecialchars($user["password"]) ?></h1>
</body>

</html>