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
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("header.php");
    ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST["formAction"];

        if ($action == "create_chat") {
            $user1 = $_SESSION["login"];
            $user2 = $_POST["username"];
            $user2 = str_replace("@", "", $user2);
            create_chat($user1, $user2);
        } elseif ($action == "delete_chat") {
            $user1 = $_SESSION["login"];
            $user2 = $_POST["toLogin"];
            delete_chat($user1, $user2);
        }
    }

    if (isset($_GET["toLogin"])) {
        $user1 = $_SESSION["login"];
        $user2 = $_GET["toLogin"];
    }

    $login = $_SESSION["login"];
    $chats = get_chats_for_user($login);
    ?>

    <div class="container">
        <div class="user-list">

            <?php
            for ($i = 0; $i < count($chats); $i++) {
                $chat = $chats[$i];
                if ($chat["user1"] == $login) {
                    $toLogin = $chat['user2'];
                } else {
                    $toLogin = $chat['user1'];
                }
            ?>
                <button id="<?php echo $toLogin ?>" class="user-list-item <?php if (isset($_GET["toLogin"]) && $toLogin == $_GET["toLogin"]) echo "active" ?>" onclick='setToLogin("<?php echo $toLogin ?>")'>
                    <img class="user-list-item img" src="user.png" />
                    <div>
                        <div>
                            <?php echo get_user($toLogin)["firstName"] . " " . get_user($toLogin)["lastName"] ?>
                        </div>
                        <div>
                            @<?php echo $toLogin ?>
                        </div>
                    </div>
                </button>

            <?php
            }
            ?>
        </div>

        <div class="chat-bg">
            <div class="chat-output">

            </div>
            <div class="chat-controls">
                <input id="text" name="text" required></input><br><br>
                <button id="submitSend" onclick="sendMessage()">></button>
            </div>
        </div>

    </div>

    <div class="chat-actions">
        <button id="createChat">Create Chat</button>
        <button onclick="deleteChat()">Delete This Chat</button>
    </div>

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
        let toLogin = "<?php if (isset($_GET['toLogin'])) echo $_GET['toLogin'] ?>";
    </script>
    <script src="index.js"></script>
</body>

</html>