<?php
session_start();
include("pdo.php");
if (!isset($user)) {
    header("Location:/login.php");
}
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
    <div class="profile">
        <div>
            <img src="user.png">
        </div>
        <div class="profile-item">
            <strong>First Name: </strong>
            <span><?php echo htmlspecialchars($user["firstName"]) ?></span>
        </div>

        <div class="profile-item">
            <strong>Last Name: </strong>
            <span><?php echo htmlspecialchars($user["lastName"]) ?></span>
        </div>

        <div class="profile-item">
            <strong>Date of birth: </strong>
            <span><?php echo htmlspecialchars($user["dateOfBirth"]) ?></span>
        </div>

        <div class="profile-item">
            <strong>Login: </strong>
            <span>@<?php echo htmlspecialchars($user["login"]) ?></span>
        </div class="profile-item">

        <a href="user-edit.php" class="profile-item">Edit Profile</a>
    </div>
</body>

</html>