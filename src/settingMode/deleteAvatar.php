<?php
session_start();
require "../../core/conf.inc.php";
require "../../core/functions.php";

$email = $_SESSION['email'];

// Connexion à la base de données
$connect = connectDB();

// Requête d'insertion de l'image en base de données
$queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET img_avatar = NULL WHERE email=:email");
$queryPrepared->execute([
    "email" => $email,
]);
header('location: settingUser.php');