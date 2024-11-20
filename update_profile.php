<?php
session_start();
include("pdo.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_SESSION["login"];

    // Данные для вставки
    $name = $_POST["firstName"];
    $lname = $_POST["lastName"];
    $date = $_POST["dateOfBirth"];

    // валидация
    if (strlen($name) == 0 || strlen($name) > 50) {
        header("Location:/register.php");
        exit();
    }
    if (strlen($lname) == 0 || strlen($lname) > 50) {
        header("Location:/register.php");
        exit();
    }

    update_user($login, $name, $lname, $date);
    header("Location:/user.php");
}
