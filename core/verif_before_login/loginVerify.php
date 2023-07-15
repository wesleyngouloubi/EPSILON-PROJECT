<?php 
	session_start(); 
	require "../functions.php";
	require "../conf.inc.php";
	

	if(!empty($_SESSION["email_try"]) && !empty($_SESSION["pwd_try"])) {
		
		$email = cleanEmail($_SESSION["email_try"]);
		$pwdUser = $_SESSION["pwd_try"]; 
		unset($_SESSION["email_try"], $_SESSION["pwd_try"], $_SESSION["usedImageIndices"]);

		// Vérifier que dans la base de données il existe cette adresse mail de l'utilisateur
		$connection = connectDB();

		$queryPrepared = $connection->prepare("SELECT pwd, ".DB_PREFIX."USER.nom, status, prenom, date_naissance, ROLE_id_role, TEAM_id_team
		FROM ".DB_PREFIX."USER WHERE email=:email");

		$queryPrepared->execute([
			"email"=>$email
		]);

		$result = $queryPrepared->fetch();

		$validate = $result["status"];
		

		if(empty($result)){
			$listOfErrors[] = 'Votre email et mot de passe sont incorrects';
            // Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
            $_SESSION['errors'] = $listOfErrors;
            header("location: ../../connexion_user/login.php");

		}else if($validate != 1) {
			$listOfErrors[] = 'Votre email n\'a pas été vérifier, consulter vos mails (spams)';
            // Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
            $_SESSION['errors'] = $listOfErrors;
            header("location: ../../connexion_user/login.php");

		}else if($validate == 2) {
			$listOfErrors[] = 'Votre compte a été supprimé, contacter l\'administrateur';
            // Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
            $_SESSION['errors'] = $listOfErrors;
            header("location: ../../connexion_user/login.php");
		}else if(password_verify($pwdUser, $result["pwd"])){
        
			$_SESSION["email"] = $email; 
			$_SESSION["login"] = 1;
			$_SESSION["nom"] = $result["nom"];
			$_SESSION["prenom"] = $result["prenom"];
			$_SESSION["role"] = $result["ROLE_id_role"];
			$_SESSION["team"] = $result["TEAM_id_team"];
			$_SESSION["date_naissance"] = $result["date_naissance"];
			$birthday = $result["date_naissance"];
  			$aujourdhui = date("Y-m-d");
  			$age = date_diff(date_create($birthday	), date_create($aujourdhui));
			$_SESSION["age"] = $age->format('%y');
			
			header("Location:../../index.php");
		} else{
			$listOfErrors[] = 'Votre email et mot de passe sont incorrects';
            // Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
            $_SESSION['errors'] = $listOfErrors;
            header("location: ../../connexion_user/login.php");
		}	

	}elseif(empty($_SESSION["email_try"]) || empty($_SESSION["pwd_try"])) {
		$listOfErrors[] = 'Votre email et mot de passe sont incorrects';
        // Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
        $_SESSION['errors'] = $listOfErrors;
        header("location: ../../connexion_user/login.php");
	}
?>