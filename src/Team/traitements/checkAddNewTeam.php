<?php
session_start();
require "../../../core/conf.inc.php";
require "../../../core/functions.php";

if( count($_POST) != 1
	|| empty($_POST["team"])){
	die("Tentative de HACK !!!!");
}


$team = htmlspecialchars(cleanFirstname($_POST["team"]));

$listOfErrors = [];

$regexTeamName = '#^[A-Z][\p{L}-]*$#'; 

// Team Name -> >= 2 caractères
if(strlen($team) < 2){
	$listOfErrors[] = "Le nom de team doit faire plus de 2 caractères";
}elseif( !preg_match($regexTeamName, $team) ){
    $listOfErrors[] = "Le nom de team contient des caractères non autorisés";

}else{
    $connection = connectDB();
    $queryPreparedName = $connection->prepare("SELECT id_team FROM TEAM WHERE TEAM.nom = :team");
    $queryPreparedName->execute(["team"=>$team]);

    $result = $queryPreparedName->fetch();

    if(!empty($result)){
        $listOfErrors[] = "Le nom de team existe déjà";
    }
}



if(empty($listOfErrors)){
    

    
    $queryPrepared = $connection->prepare("INSERT INTO TEAM(nom, date_creation, createur_id, cle_invitation)
							VALUES (:team, NOW(), (SELECT id_user FROM ".DB_PREFIX."USER where email = :email), :key)");
    $key_invitation = uniqid();
	$queryPrepared->execute([
								"team"=>$team,
                                "email"=>$_SESSION["email"],
                                "key"=>$key_invitation
							]);
    
    $queryPrepared2 = $connection->prepare("UPDATE EPSFWK_USER SET TEAM_id_team=(SELECT TEAM.id_team FROM TEAM JOIN EPSFWK_USER ON TEAM.createur_id = EPSFWK_USER.id_user WHERE EPSFWK_USER.email = :email AND TEAM.nom = :nom)  WHERE EPSFWK_USER.email = :email");
    $queryPrepared2->execute([
                                "email"=>$_SESSION["email"],
                                "nom"=>$team
    ]);
    
    header('Location:../myTeam.php');

}else{
    //SI NOK
    //Redirection sur creation de team avec les erreurs
    $_SESSION['errors'] = $listOfErrors;
    header("location: ../createTeam.php");
    
                    
}    

?>