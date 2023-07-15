<?php


// clean un nom de famille
function cleanLastname($lastname){
	return strtoupper(trim($lastname));
}

// clean un prénom
function cleanFirstname($firstname){
	return ucwords(strtolower(trim($firstname)));
}

// clean un email
function cleanEmail($email){
	return strtolower(trim($email));
}


//elle sert à nous connecter à notre BDD
function connectDB(){
	//Connexion à la bdd (DSN, USER, PWD)
	try{
		$connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PWD);
	}catch(Exception $e){
		die("Erreur SQL".$e->getMessage());
	}
	return $connection;
}

//savoir si l'user est connecté 
function isConnected(){
	// On vérifie si email et login sont pas vide
	if(!empty($_SESSION["email"]) && !empty($_SESSION["login"])){
		// connection à la bdd
		$connect = connectDB();
		// Requête préparé qui va aller chercher dans la bdd
		$queryPrepared = $connect->prepare("SELECT id_user FROM ".DB_PREFIX."USER WHERE email=:email");
		// Executer notre requete en remplaçant :email dans la requete par celle de l'user 
		$queryPrepared->execute(["email"=>$_SESSION["email"]]);
		// Aller chercher notre résultat dans le jeu de résultat
		$result = $queryPrepared->fetch();
		// Si l'email que l'on a en session existe aussi dans la bdd
		// Alors on part du principe que l'utilisateur est bien connecté
		if(!empty($result)){
			return true;
		}
	}
	return false;
}

//savoir si l'admin est connecté
function isAdmin(){
	// Si l'admin est connecté ou pas
	if(isConnected()){
		// la variable superglobal renvoie le role de la bdd
		// et si son role est admin Alors il est connecté sinon non 
		if($_SESSION["role"] == "admin"){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

//si l'user n'est pas connecté alors il est redirigé
function redirectIfNotConnected(){
	if(!isConnected()){
		header("Location:/connexion_user/login.php");
	}
}

//si l'user est connecté et essaye d'aller sur la page login par exemple
//alors il est redirigé
function redirectIfAlreadyConnected(){
	if(isConnected()){
		header("Location:/index.php");
	}
}

function generatecode(){
	return bin2hex(random_bytes(2));
}

function verificateMail(){
	$codeMail = md5(uniqid(mt_rand()));
	return $codeMail;
}

function getStadiums(){
    // connexion à la base de données
    $connect = connectDB();

    // requete pour récuperer les stades, le prix et leurs categories
    $queryPrepared= $connect->prepare("SELECT STADIUM.id_stadium, STADIUM.CATEGORY_id_category AS id_category, CATEGORY.prix_heure
	FROM STADIUM
	JOIN CATEGORY ON STADIUM.CATEGORY_id_category = CATEGORY.id_category");

    
    $queryPrepared->execute();

	$stadiums = $queryPrepared->fetchAll();

    return $stadiums;
}

function whichTeam(){// requête pour identifier l'équipe de l'utilisateur connecté
	$connect = connectDB();
	$queryPrepared = $connect->prepare("SELECT TEAM.id_team, TEAM.cle_invitation,TEAM.nom AS nom_equipe, TEAM.createur_id, ".DB_PREFIX."USER.nom, ".DB_PREFIX."USER.prenom, ".DB_PREFIX."USER.id_user FROM TEAM JOIN ".DB_PREFIX."USER ON TEAM.id_team = ".DB_PREFIX."USER.TEAM_id_team WHERE ".DB_PREFIX."USER.email = :email");
	$queryPrepared->execute(["email"=>$_SESSION['email']]);
	$team = $queryPrepared->fetch();
	
	return $team;
}

function redirectIfHaveNotTeam(){
	$team = whichTeam();
	if(empty($team)){
		header("Location:/src/Team/myTeam.php");
	}
}

function redirectIfHaveTeam(){
	$team = whichTeam();
	if(!empty($team)){
		header("Location:/src/Team/myTeam.php");
	}
}