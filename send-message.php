<?php
session_start();
include("pdo.php");

$user1 = $_SESSION["login"];
$user2 = $_GET["toLogin"];

$chat = get_chat($user1, $user2);

if ($chat == NULL) {
    $chatId = create_chat($user1, $user2);
} else {
    $chatId = $chat["chatID"];
}
add_message($user1, $user2, $chatId);
