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
    if (!isset($user)) {
        header("Location:/login.php");
    }
    ?>
    <form method="POST" action="/index.php?toLogin=<?php echo $_GET['toLogin'] ?>">
        <input type="hidden" name="formAction" value="add">
        <h2>Add Messages</h2>
        <textarea name="text" rows="4" cols="50" required></textarea><br><br>
        <input type="submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $hide = $_POST["formAction"];

        if ($hide == "create_chat") {
            $user1 = $_SESSION["login"];
            $user2 = $_POST["username"];
            $user2 = str_replace("@", "", $user2);
            create_chat($user1, $user2);
        } elseif ($hide == "delete_chat") {
            $user1 = $_SESSION["login"];
            $user2 = $_POST["toLogin"];
            delete_chat($user1, $user2);
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

        /* echo "<h1>" . $user2 . "</h1>";

            $chatId = get_chat($user1, $user2)['chatID'];

            $results = get_messages($user1, $user2, $chatId);
            if ($results) {

                for ($i = 0; $i < count($results); $i++) {
                    $msg = $results[$i];
                    $messageClass = ($msg['userFrom'] == $user1) ? 'my-message' : 'their-message';
                    echo "<div class='message $messageClass'><strong>" . htmlspecialchars($msg['userFrom']) . ":</strong> " . htmlspecialchars($msg['message']) . "</div>";
                }
            } */
    }

    echo "<h1>My chats</h1>";

    $login = $_SESSION["login"];
    $chats = get_chats_for_user($login);

    for ($i = 0; $i < count($chats); $i++) {
        $chat = $chats[$i];
        if ($chat["user1"] == $login) {
            $toLogin = $chat['user2'];
        } else {
            $toLogin = $chat['user1'];
        }

        echo "<button onclick='setToLogin(`" . $toLogin . "`)'>" . "<div>" . get_user($toLogin)["firstName"] . " " . get_user($toLogin)["lastName"] . "</div> " . "<div>" . $toLogin . "</div>" . "</button>"
;
    }
    ?>

    <div class="chat-bg">
        <div class="chat-output">

        </div>
        <textarea id="text" name="text" rows="4" cols="50" required></textarea><br><br>
        <button id="submit" onclick="sendMessage()">></button>
    </div>
    <button id="createChat">Create Chat</button>
    <form method="post">
        <input type="hidden" name="formAction" value="delete_chat">
        <input type="hidden" name="toLogin" value="<?php echo $_GET['toLogin'] ?>">
        <button type="submit">Delete</button>
    </form>


    <!-- Create Chat Modal -->
    <div id="modal">
        <div class="modal-container">
            <form method="post">
                <div>
                    <h2>Create Chat</h2>
                </div>
                <div>
                    <input type="hidden" name="formAction" value="create_chat">
                    <input type="text" id="username" name="username" placeholder="@username" required>
                    <button type="submit">Create Chat</button>
                </div>
            </form>
        </div>
    </div>
    <script src="modal.js"></script>
    <script>
        let login = "<?php echo $_SESSION['login']; ?>";
        let toLogin = "<?php echo $_GET['toLogin'] ?>"

        function poll() {
            fetch(`http://localhost:1234/message_poll.php?toLogin=${toLogin}`)
                .then(response => response.json())
                .then(data => {
                    //document.getElementById("root").innerHTML = data.time
                    let div = document.querySelector(".chat-output");
                    div.innerHTML = "";
                    for (let i = 0; i < data.length; i++) {
                        let msg = data[i];
                        let messageClass = (msg['userFrom'] == login) ? 'my-message' : 'their-message';
                        console.log(msg["message"])
                        div.innerHTML += `<div class='message ${messageClass}'><strong>` + msg['userFrom'] +
                            `:</strong>` + msg['message'] + `</div>`;
                    }
                    setTimeout(poll, 1500); // повторять запрос каждую секунду1
                });
        }

        let sendMessage = () => {
            let text = document.getElementById("text").value;
            let formData = new FormData();
            formData.append('text', text);

            console.log(toLogin);
            fetch(`http://localhost:1234/send-message.php?toLogin=${toLogin}`, {
                method: "POST",
                body: formData
            });
        };
        let setToLogin = (newValue) => {
            toLogin = newValue;

            // опционально: меняет ссылку в браузере
            history.replaceState(null, '', '/index.php?toLogin=' + toLogin);
        }


        poll()
    </script>
</body>

</html>