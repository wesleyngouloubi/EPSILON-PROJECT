<?php
    require "../../template/header.php";
	session_start();
	require "../conf.inc.php";
    require "../functions.php";


    if(isset($_GET['cle_auth'])) {
        $cle_auth=$_GET['cle_auth'];
        $connect = connectDB();

        //Insertion du USER en bdd
        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET status=:status WHERE tokens_mail=:cle_auth");
      
        $queryPrepared->execute([
          "status"=>1,
          "cle_auth"=>$cle_auth
        ]);

        header("location: ../../connexion_user/login.php");
    }


?>