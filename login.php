<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include("header.php")?>
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
</body>
</html>