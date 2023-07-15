<?php
session_start();
require "../../core/conf.inc.php";
require "../../core/functions.php";

if( count($_POST) != 8
	|| empty($_POST["nom"])
	|| empty($_POST["prenom"])
	|| empty($_POST["date_naissance"])
	|| !isset($_POST["genre"])
	|| !isset($_POST["role"])
	|| empty($_POST["email"])
    || empty($_POST["pwd"])
    || empty($_POST["pwdConfirm"])
	
)

{
	die("Tentative de HACK !!!!");
}


$lastname = cleanLastname($_POST["nom"]);
$firstname = cleanFirstname($_POST["prenom"]);
$email = cleanEmail($_POST["email"]);
$gender = $_POST["genre"];
$birthday = $_POST["date_naissance"];
$role = $_POST["role"];
$pwd = $_POST["pwd"];
$pwdConfirm = $_POST["pwdConfirm"];

$listOfErrors = [];

$regexNomPrenom = '#^[A-Z][\p{L}-]*$#';

// Lastname -> >= 2 caractères
if(strlen($lastname) < 2){
	$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}elseif( !preg_match($regexNomPrenom, $lastname) ){
    $listOfErrors[] = "Le nom contient des caractères non autorisés";

}

// Firstname -> >= 2 caractères
if(strlen($firstname) < 2){
	$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}elseif( !preg_match($regexNomPrenom, $firstname) ){
    $listOfErrors[] = "Le prénom contient des caractères non autorisés";
}

// City
$listOfGenders = ["m","f","o"];
if( !in_array($gender, $listOfGenders) ){
	$listOfErrors[] = "Le genre n'existe pas";
}

$listOfRoles = ["admin", "user", "vip"];
if( !in_array($role, $listOfRoles) ){
	$listOfErrors[] = "Le rôle n'existe pas";
}


if( strlen($pwd)<8 || 
	!preg_match("#[a-z]#", $pwd)  || 
	!preg_match("#[A-Z]#", $pwd)  || 
	!preg_match("#[0-9]#", $pwd) ){

		$listOfErrors[] = "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules et des chiifres";
}   


//pwdConfirm -> = Pwd
if( $pwd != $pwdConfirm ){
		$listOfErrors[] = "Votre mot de passe de confirmation ne correspond pas";
}

// Email -> Format


if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
	$listOfErrors[] = "L'email est incorrect";
}else{ 
	// Email -> Unicité
	$connection = connectDB();
	$queryPrepared = $connection->prepare("SELECT id_user FROM ".DB_PREFIX."USER WHERE email=:email");
	$queryPrepared->execute(["email"=>$email]);

	$result = $queryPrepared->fetch();

	if(!empty($result)){
		$listOfErrors[]="L'email est déjà utilisé";


	}
}

if(empty($listOfErrors)){

    $queryPrepared = $connection->prepare("INSERT INTO ".DB_PREFIX."USER(nom, prenom, email, pwd, genre, date_naissance, date_creation, ROLE_id_role, status) 
							VALUES (:lastname, :firstname, :email, :pwd, :gender, :birthday, NOW(), :role, 1)");

	$queryPrepared->execute([
								"lastname"=>$lastname,
								"firstname"=>$firstname,
								"email"=>$email,
								"pwd"=>password_hash($pwd,PASSWORD_DEFAULT),
								"birthday"=>$birthday,
								"gender"=>$gender,
								"role"=>$role
							]);
                        
    $_SESSION['successAdd'] = 1;
    header('Location: ../users.php');

}else{
    //SI NOK
    //Redirection sur register avec les erreurs
    $_SESSION['errors'] = $listOfErrors;
    header("location: ../formAddUser.php?nom=$lastname&prenom=$firstname&date_naissance=$birthday&genre=$gender&email=$email&role=$role");
    
                    
}    

?>