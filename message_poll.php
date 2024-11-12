<?php
session_start();
include("pdo.php");

header('Content-Type: application/json');

$user1 = $_SESSION["login"];
$user2 = $_GET["toLogin"];

$chatId = get_chat($user1, $user2);
if ($chatId != null) {
    $data = get_messages($user1, $user2, $chatId);
} else {
    $data = array("error" => "no chat found");
}

// $data['user1'] = $user1;
// $data['user2'] = $user2;
// $data['chatID'] = $chatId;

echo json_encode($data);
