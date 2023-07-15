
<?php
	session_start();
	require "../functions.php";
	require "../conf.inc.php";

	// // Exemple de code côté serveur en PHP
	// $response = array(
	// 	'success' => true, // ou false en cas d'échec
	// 	'error' => '', // message d'erreur en cas d'échec
	// );

	// // Envoi de la réponse JSON
	// header('Content-Type: application/json');
	// echo json_encode($response);

	//Vérification du nb et des champs required non vides
	if( count($_POST) != 9
		|| !isset($_POST["gender"])
		|| empty($_POST["lastname"])
		|| empty($_POST["firstname"])
		|| empty($_POST["birthday"])
        || empty($_POST["email"])
		|| empty($_POST["phone"])
		|| empty($_POST["pwd"])
		|| empty($_POST["pwdConfirm"])
		|| !isset($_POST["cgu"])

	)
	{
		die("Tentative de HACK !!!!");
	}

    //Nettoyage les valeurs
    $gender = $_POST["gender"];
	$lastname = htmlspecialchars(cleanLastname($_POST["lastname"]));
	$firstname = htmlspecialchars(cleanFirstname($_POST["firstname"]));
    $birthday = $_POST["birthday"];
    $email = htmlspecialchars(cleanEmail($_POST["email"]));
    $phone =  htmlspecialchars($_POST["phone"]);
	$pwd = $_POST["pwd"];
	$pwdConfirm = $_POST["pwdConfirm"];

	$_SESSION['email'] = $email; 
	$_SESSION['firstname'] = $firstname;

    // Tableau des erreurs
	$listOfErrors = [];

	// Gender -> Soit 0, 1 ou 2
	$listOfGenders = ['m','f','o'];
	if( !in_array($gender, $listOfGenders) ){
		$listOfErrors[] = "Le genre n'existe pas";
	}

	// On met des conditions à l'user sur son Nom et prénom
	if(strlen($lastname) < 2){
		$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
	}

	if(strlen($firstname) < 2){
		$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
	}

    // On vérifie son âge (protection de la jeunesse)
	$birthdayExploded = explode("-", $birthday);

	if( !checkdate($birthdayExploded[1], $birthdayExploded[2], $birthdayExploded[0])){
		$listOfErrors[] = "Format de date incorrect";
	}else{
		$todaySecond = time();
		$birthdaySecond = strtotime($birthday);
		$ageSecond = $todaySecond - $birthdaySecond;
		$age = $ageSecond/60/60/24/365.25;
		if( $age < 6 || $age > 80  ) {
			$listOfErrors[] = "Vous n'avez pas l'âge requis";
		}
	}

    // Email doit être au bon Format
	if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
		$listOfErrors[] = "L'email est incorrect";
	}else{ 
		//On vérifie si l'email n'a pas déjà été prise par un autre user
		$connection = connectDB();
		$queryPrepared = $connection->prepare("SELECT id_user FROM ".DB_PREFIX."USER WHERE email=:email");
		$queryPrepared->execute(["email"=>$email]);

		$result = $queryPrepared->fetch();

		if(!empty($result)){
			$listOfErrors[]="L'email est déjà utilisé";
		}
	}

    
    if ( !preg_match('#^[1-9][0-9]{8}$#', $phone)) {
        $listOfErrors[] = "Le numéro de téléphone entré est incorrect.";
    }

	// Pwd -> Min 8 caractères avec minuscules majuscules et chiffres
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

	
    if(empty($listOfErrors))
	{
        //Insertion du USER en bdd
		$queryPrepared = $connection->prepare("INSERT INTO ".DB_PREFIX."USER (status, genre, nom, prenom, date_naissance, email, phone, pwd, date_creation, ROLE_id_role) VALUES
		(:status, :gender, :lastname, :firstname, :birthday, :email, :phone, :pwd, NOW(), :role)");

		$queryPrepared->execute([
									"status"=>0,
									"gender"=>$gender,
									"lastname"=>$lastname,
									"firstname"=>$firstname,
									"birthday"=>$birthday,
									"email"=>$email,
									"phone"=>$phone,
									"pwd"=>password_hash($pwd,PASSWORD_DEFAULT),
									"role"=>"user"

								]);

		//Redirection vers la page login
		$_SESSION['firstname'] = $firstname;
		$_SESSION['email'] = $email;
		header("location: ../gestion_mail/mailSend.php");

	}else{
		// Si listOfErrors n'est pas vide alors redirection sur register avec les erreurs
		$_SESSION['errors'] = $listOfErrors;
		header("location: ../../connexion_user/registerAriane.php");
	}

	

	