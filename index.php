<?php
session_start();
include("pdo.php");
?>
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
    include("header.php");
    ?>
    <form method="POST" action="">
        <input type="hidden" name="formAction" value="add">
        <h2>Отправка сообщения</h2>

        <label for="toId">toId:</label>
        <input type="text" id="toId" name="toId" required><br><br>

        <label for="text">text:</label><br>
        <textarea id="text" name="text" rows="4" cols="50" required></textarea><br><br>

        <input type="submit">
    </form>

    <form method="POST" action="">
        <input type="hidden" name="formAction" value="view">
        <h2>Просмотреть сообщения</h2>

        <label for="toId">toId:</label>
        <input type="text" id="toId" name="toId" required><br><br>

        <input type="submit">
    </form>
    <div class="chat-output">

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Данные для вставки
            $user1 = $_SESSION["id"];
            $user2 = $_POST["toId"];

            $chat = get_chat($user1, $user2);

            if ($chat == NULL) {
                $chatId = create_chat($user1, $user2);
            } else {
                $chatId = $chat["chatID"];
            }

            $hide = $_POST["formAction"];


            if ($hide == "add") {
                add_message($user1, $user2, $chatId);
            } else {
                $results = get_messages($user1, $user2, $chatId);
                if ($results) {

                    for ($i = 0; $i < count($results); $i++) {
                        $msg = $results[$i];
                        $messageClass = ($msg['userFrom'] == $user1) ? 'my-message' : 'their-message';
                        echo "<div class='message $messageClass'><strong>" . htmlspecialchars($msg['userFrom']) . ":</strong> " . htmlspecialchars($msg['message']) . "</div>";
                    }
                }
            }
            $results = get_chats_for_user($_SESSION["id"]);
            for ($i = 0; $i < count($results); $i++) {
                $chat = $results[$i];
                echo "chat ID = " . $chat["chatID"] . ", " . "user1 = " . $chat["user1"] . ", " . "user2 = " . $chat["user2"];
            }
        }
        ?>
    </div>
</body>

</html>

</html>