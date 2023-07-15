<?php
    // Sert à delete une team depuis le back office 
    session_start();
    require "../../core/conf.inc.php";
    require "../../core/functions.php";

    if(!isAdmin()){
        header("location: /index.php");
    }

    if( count($_GET) != 1 || empty($_GET["id_team"])){
        header("location: ../teams.php");
    }
    
    $connect = connectDB();
    $queryPrepared = $connect->prepare("DELETE FROM TEAM WHERE id_team=:id");
    $queryPrepared->execute(
        ["id"=>$_GET['id_team']]
    );

    $_SESSION["successRemove"]=1;
    header("Location: ../teams.php");
?>