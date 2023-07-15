<?php
    // Sert à delete une reservation depuis le back office 
    session_start();
    require "../../core/conf.inc.php";
    require "../../core/functions.php";

    if(!isAdmin()){
        header("location: /index.php");
    }

    if( count($_GET) != 1 || empty($_GET["id_reservation"])){
        header("location: ../reservations.php");
    }
    
    $connect = connectDB();
    $queryPrepared = $connect->prepare("DELETE FROM RESERVATION WHERE id_reservation=:id");
    $queryPrepared->execute(
        ["id"=>$_GET['id_reservation']]
    );

    $_SESSION["successRemove"]=1;
    header("Location: ../reservations.php");
?>