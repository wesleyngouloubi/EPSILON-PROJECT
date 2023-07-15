<?php
session_start();
require "../../../core/conf.inc.php";
require "../../../core/functions.php";

if( count($_POST) != 1
	|| empty($_POST["msg"])){
	die("Tentative de HACK !!!!");
}


$msg = htmlspecialchars($_POST["msg"]);

$connection = connectDB();
$queryPrepared = $connection->prepare("INSERT INTO TEAM_CHAT(contenu_message, date_emission, USER_id_user, TEAM_id_team_tc) 
                                        VALUES(:msg, NOW(), (SELECT id_user FROM ".DB_PREFIX."USER where email = :email), (SELECT TEAM_id_team FROM ".DB_PREFIX."USER where email = :email))");
$queryPrepared->execute(["msg"=>$msg,"email"=>$_SESSION["email"]]);

header("Location: ../teamChat.php");