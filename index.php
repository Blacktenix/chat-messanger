<?php
session_start();
include("pdo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("header.php");
    ?>
    <form method="POST" action="/index.php?toLogin=<?php echo $_GET['toLogin'] ?>">
        <input type="hidden" name="formAction" value="add">
        <h2>Add Messages</h2>

        <label for="toLogin">toLogin:</label>
        <input type="text" id="toLogin" name="toLogin" required><br><br>

        <label for="text">text:</label><br>
        <textarea id="text" name="text" rows="4" cols="50" required></textarea><br><br>

        <input type="submit">
    </form>

    <div class="chat-output">

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Данные для вставки
            $user1 = $_SESSION["login"];
            $user2 = $_POST["toLogin"];

            $chat = get_chat($user1, $user2);

            if ($chat == NULL) {
                $chatId = create_chat($user1, $user2);
            } else {
                $chatId = $chat["chatID"];
            }

            $hide = $_POST["formAction"];

            if ($hide == "add") {
                add_message($user1, $user2, $chatId);
            } elseif ($hide = "create_chat") {
                $user1 = $_SESSION["login"];
                $user2 = $_POST["username"];
                $user2 = str_replace("@", "", $user2);
                create_chat($user1, $user2);
            }

            /* $results = get_chats_for_user($_SESSION["login"]);
            for ($i = 0; $i < count($results); $i++) {
                $chat = $results[$i];
                echo "chat ID = " . $chat["chatID"] . ", " . "user1 = " . $chat["user1"] . ", " . "user2 = " . $chat["user2"];
            } */
        }

        if (isset($_GET["toLogin"])) {
            $user1 = $_SESSION["login"];
            $user2 = $_GET["toLogin"];

            echo "<h1>" . $user2 . "</h1>";

            $chatId = get_chat($user1, $user2)['chatID'];

            $results = get_messages($user1, $user2, $chatId);
            if ($results) {

                for ($i = 0; $i < count($results); $i++) {
                    $msg = $results[$i];
                    $messageClass = ($msg['userFrom'] == $user1) ? 'my-message' : 'their-message';
                    echo "<div class='message $messageClass'><strong>" . htmlspecialchars($msg['userFrom']) . ":</strong> " . htmlspecialchars($msg['message']) . "</div>";
                }
            }
        }
        ?>
        <button id="createChat">Create Chat</button>
    </div>

    <!-- Create Chat Modal -->
    <div id="modal">
        <div class="modal-container">
            <form method="post">
                <div>
                    <h2>Create Chat</h2>
                </div>
                <div> <input type="hidden" name="formAction" value="create_chat">
                    <input type="text" id="username" name="username" placeholder="@username" required>
                    <button type="submit">Create Chat</button>
                </div>
            </form>
        </div>
    </div>
    <script src="modal.js"></script>
</body>

</html>

</html>