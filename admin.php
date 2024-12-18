<?php
session_start();
include("pdo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Admin Page</h1>

    <h2>Users</h2>
    <table>
        <tr>
            <th>login</th>
            <th>firstName</th>
            <th>LastName</th>
            <th>dateOfBirth</th>
            <th>login</th>
            <th>password</th>

        </tr>
        <?php


        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM users";
            $stmt = $pdo->prepare($sql);
            var_dump($stmt->execute());
            $results = $stmt->fetchAll();


            for ($i = 0; $i < count($results); $i++) {
                $user = $results[$i];
                echo "<tr>";
                echo "<td>" . $user["login"] . "</td>";
                echo "<td>" . $user["firstName"] . "</td>";
                echo "<td>" . $user["lastName"] . "</td>";
                echo "<td>" . $user["dateOfBirth"] . "</td>";
                echo "<td>" . $user["password"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <h2>Chats</h2>
    <table>
        <tr>
            <th>chatID</th>
            <th>user1</th>
            <th>user2</th>
        </tr>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM chats";
            $stmt = $pdo->prepare($sql);
            var_dump($stmt->execute());
            $results = $stmt->fetchAll();


            for ($i = 0; $i < count($results); $i++) {
                $chat = $results[$i];
                echo "<tr>";
                echo "<td>" . $chat["chatID"] . "</td>";
                echo "<td>" . $chat["user1"] . "</td>";
                echo "<td>" . $chat["user2"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <h2>Messages</h2>
    <table>
        <tr>
            <th>chatID</th>
            <th>messageID</th>
            <th>message</th>
            <th>userTo</th>
            <th>useFrom</th>
        </tr>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM messages";
            $stmt = $pdo->prepare($sql);
            var_dump($stmt->execute());
            $results = $stmt->fetchAll();


            for ($i = 0; $i < count($results); $i++) {
                $chat = $results[$i];
                echo "<tr>";
                echo "<td>" . $chat["chatID"] . "</td>";
                echo "<td>" . $chat["messageID"] . "</td>";
                echo "<td>" . $chat["message"] . "</td>";
                echo "<td>" . $chat["userTo"] . "</td>";
                echo "<td>" . $chat["userFrom"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <?php
    phpinfo();
    ?>
</body>


</html>