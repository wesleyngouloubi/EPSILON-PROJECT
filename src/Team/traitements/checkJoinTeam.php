<?php
session_start();
require "../../../core/conf.inc.php";
require "../../../core/functions.php";

$error=[];
if(!isConnected()){
    $error[]="Tu dois être connecté(e) pour rejoindre une équipe ! Retente une fois connecté(e)";
    $_SESSION["errors"]=$error;
    header("location: /connexion_user/login.php");
}

if( count($_GET) != 1 || empty($_GET["invit"])){
	header("location: ../myTeam.php");
}

$keyInvit = $_GET["invit"];

$connect = connectDB();
$queryPrepared1 = $connect->prepare("SELECT id_team FROM TEAM WHERE cle_invitation = :keyInvit");
$queryPrepared1->execute(["keyInvit"=>$keyInvit]);
$team = $queryPrepared1->fetchColumn();

if(!empty($team)){
    //la clé d'invit existe et est bien lié à une team, on verifie maintenant si l'user n'a pas déjà une team
    $queryPrepared1 = $connect->prepare("SELECT prenom FROM ".DB_PREFIX."USER WHERE email = :email AND TEAM_id_team IS NOT NULL");
    $queryPrepared1->execute([
        "email"=>$_SESSION["email"]
    ]);
    $result1 = $queryPrepared1->fetch();

    if(empty($result1)){ //si il a pas on peut l'ajouter à la team sans problème
        $queryPrepared2 = $connect->prepare("UPDATE EPSFWK_USER SET TEAM_id_team= :team WHERE EPSFWK_USER.email = :email");
        $queryPrepared2->execute([
                                    "team"=>$team,
                                    "email"=>$_SESSION["email"]
        ]);
        header('Location:../myTeam.php');
    }else{
        $error[]="Tu dois quitter ta team actuelle pour rejoindre une autre !";
        $_SESSION["errors"]=$error;
        header('Location:../myTeam.php');

    }
    
}else{
    $error[]="Cette clé d'invitation n'existe pas (ou plus !)";
    $_SESSION["errors"]=$error;
    header('Location:../myTeam.php');
}