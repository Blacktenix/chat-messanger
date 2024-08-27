<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отправка сообщения</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    session_start();
    include("header.php");
    ?>
    <form method="POST" action="">
        <input type="hidden" name="formAction" value="add">
        <h2>Отправка сообщения</h2>
        <label for="fromId">fromId:</label>
        <input type="text" id="fromId" name="fromId" required><br><br>

        <label for="toId">toId:</label>
        <input type="text" id="toId" name="toId" required><br><br>

        <label for="text">text:</label><br>
        <textarea id="text" name="text" rows="4" cols="50" required></textarea><br><br>

        <input type="submit">
    </form>

    <form method="POST" action="">
        <input type="hidden" name="formAction" value="view">
        <h2>Просмотреть сообщения</h2>
        <label for="fromId">fromId:</label>
        <input type="text" id="fromId" name="fromId" required><br><br>

        <label for="toId">toId:</label>
        <input type="text" id="toId" name="toId" required><br><br>

        <input type="submit">
    </form>
    <div class="chat-output">

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("pdo.php");

            // Данные для вставки
            $user1 = $_POST["fromId"];
            $user2 = $_POST["toId"];

            $results = get_chat($user1, $user2);

            if (count($results) == 0) {
                $chatId = create_chat($user1, $user2);
            } else {
                $chatId = $results[0]["chatID"];
            }

            $hide = $_POST["formAction"];


            if ($hide == "add") {
                $sql = "SELECT MAX(messageID) FROM messages WHERE  ((userTo = :user1 AND userFrom = :user2) OR (userTo = :user2 AND userFrom = :user1)) AND chatID = :chatId";
                $stmt = $pdo->prepare($sql);
                var_dump($stmt->execute(['user1' => $user1, 'user2' => $user2, 'chatId' => $chatId]));
                $results = $stmt->fetchAll();
                $messageId = $results[0]['MAX(messageID)'] + 1;


                $sql = "INSERT INTO messages (messageID,chatID,message,userTo,userFrom) VALUES (:messageId,:chatId,:message,:user1,:user2);";
                $stmt = $pdo->prepare($sql);
                $message = $_POST["text"];
                $stmt->execute(['messageId' => $messageId, 'chatId' => $chatId, 'message' => $message, 'user1' => $user1, 'user2' => $user2]);
            } else {
                $sql = "SELECT * FROM messages WHERE  ((userTo = :user1 AND userFrom = :user2) OR (userTo = :user2 AND userFrom = :user1)) AND chatID = :chatId";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user1' => $user1, 'user2' => $user2, 'chatId' => $chatId]);
                $results = $stmt->fetchAll();
                if ($results) {
                    // foreach ($results as $msg) {
                    // Определяем, это сообщение отправителя или собеседника


                    for ($i = 0; $i < count($results); $i++) {
                        $msg = $results[$i];
                        $messageClass = ($msg['userFrom'] == $user1) ? 'my-message' : 'their-message';
                        echo "<div class='message $messageClass'><strong>" . htmlspecialchars($msg['userFrom']) . ":</strong> " . htmlspecialchars($msg['message']) . "</div>";
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>

</html>