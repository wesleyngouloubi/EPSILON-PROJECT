<?php
    session_start();
    require "../../../core/conf.inc.php";
    require "../../../core/functions.php";

    if(count($_GET) != 1 || empty($_GET["i"])){
        header("location: ../myTeam.php"); //si quelqu'un tente d'arriver sur la page avec un lien ou une key differente, il est redirigé
    }

    $connect = connectDB();
    //on recupere l'id_team de l'id récup en get
    $queryPrepared = $connect->prepare("SELECT TEAM_id_team FROM ".DB_PREFIX."USER WHERE id_user = :id");
    $queryPrepared->execute(["id"=>$_GET["i"]]);
    $result = $queryPrepared->fetch();

    //on verifie qu'il est bien dans la team du fondateur qui veut l'exclure pour eviter qu'on puisse kick nptqui en touchant au get
    if($_SESSION["team"]==$result["TEAM_id_team"]){

        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET TEAM_id_team = NULL WHERE id_user= :id_user");
        $queryPrepared->execute(["id_user"=>$_GET['i']]);
        header("Location: ../myTeam.php");
    }else{
        header("Location: ../myTeam.php"); //si quelqu'un a modifié au get pour tenter de faire quitter un autre user, on redirige comme si de rien était
                                            //et aucune action n'a été réalisé
    }