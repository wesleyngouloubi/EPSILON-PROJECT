<?php
    // Sert à delete un user depuis le back office 
    session_start();
    require "../../core/conf.inc.php";
    require "../../core/functions.php";

    if(!isAdmin()){
        header("location: /index.php");
    }

    if( count($_GET) != 1 || empty($_GET["id_user"])){
        header("location: ../reservations.php");
    }
    $connect = connectDB();
    $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."USER WHERE id_user=:id_user");
    $queryPrepared->execute(
        ["id_user"=>$_GET['id_user']]
    );
    
    $_SESSION["successRemove"]=1;
    header("Location: ../users.php");
?>