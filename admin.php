<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
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
            <th>userID</th>
            <th>firstName</th>
            <th>LastName</th>
            <th>dateOfBirth</th>
            <th>login</th>
            <th>password</th>

        </tr>
        <?php


        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include("pdo.php");
            $sql = "SELECT * FROM users";
            $stmt = $pdo->prepare($sql);
            var_dump($stmt->execute());
            $results = $stmt->fetchAll();


            for ($i = 0; $i < count($results); $i++) {
                $user = $results[$i];
                echo "<tr>";
                echo "<td>" . $user["userID"] . "</td>";
                echo "<td>" . $user["firstName"] . "</td>";
                echo "<td>" . $user["LastName"] . "</td>";
                echo "<td>" . $user["dateOfBirth"] . "</td>";
                echo "<td>" . $user["login"] . "</td>";
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
            include("pdo.php");
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

</body>

</html>