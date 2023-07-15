<?php
    session_start();
    require "../../../core/conf.inc.php";
    require "../../../core/functions.php";



    $connect = connectDB();

    $queryPrepared = $connect->prepare("SELECT id_user, TEAM_id_team FROM ".DB_PREFIX."USER WHERE email = :email");
    $queryPrepared->execute(["email"=>$_SESSION["email"]]);
    $result = $queryPrepared->fetch();

    if($_GET["i"]==$result["id_user"]){

        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET TEAM_id_team = NULL WHERE id_user= :id_user");
        $queryPrepared->execute(["id_user"=>$_GET['i']]);
        
        //on verifie si il reste des joueurs dans l'équipe, on compte le nb d'user qui sont dans la team quitté en question
        $queryPrepared2 = $connect->prepare("SELECT count(*) as nb FROM ".DB_PREFIX."USER WHERE TEAM_id_team = :team");
        $queryPrepared2->execute(["team"=>$result["TEAM_id_team"]]);
        $result2 = $queryPrepared2->fetchColumn();

        //si il n'y a plus de joueurs dans la team on peut la supprimer, cela nous interesse plus de la garder autant rendre disponible le nom mtn
        if($result2===0){
            $queryPrepared3 = $connect->prepare("DELETE FROM TEAM WHERE id_team = :team");
            $queryPrepared3->execute(["team"=>$result["TEAM_id_team"]]);

        }
        header("Location: ../myTeam.php");


    }else{
        header("Location: ../myTeam.php"); //si quelqu'un a modifié au get pour tenter de faire quitter un autre user, on redirige comme si de rien était
                                            //et aucune action n'a été réalisé
    }