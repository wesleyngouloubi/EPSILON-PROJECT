<?php
    session_start();
    require "../../core/conf.inc.php";
    require "../../core/functions.php";

    // Condition qui vérifie le nombre de champs (évite faille xss)
    if( count($_POST) != 7
        || empty($_POST["nom"])
        || empty($_POST["prenom"])
        || empty($_POST["date_naissance"])
        || !isset($_POST["genre"])
        || !isset($_POST["role"])
        || empty($_POST["email"])
        || empty($_POST["id_user"])
        || $_POST["id_user"] != $_GET["id_user"]	
    )
    {
        die("Tentative de HACK !!!!");
    }

    // On nettoie nos valeurs
    $lastname = cleanLastname($_POST["nom"]);
    $firstname = cleanFirstname($_POST["prenom"]);
    $email = cleanEmail($_POST["email"]);
    $gender = $_POST["genre"];
    $birthday = $_POST["date_naissance"];
    $role = $_POST["role"];
    $id_user = $_POST["id_user"];

    // Un tableau des erreurs 
    $listOfErrors = [];

    // Vérifie le nom et prenom sont correcte
    $regexName = '#^[A-Z][\p{L}-]*$#';

    // Condition sur Lastname *1
    if(strlen($lastname) < 2){
        $listOfErrors[] = "Le nom doit faire plus de 2 caractères";
    }elseif( !preg_match($regexName, $lastname) ){
        $listOfErrors[] = "Le nom contient des caractères non autorisés";

    }

    // La même chose Firstname *1 
    if(strlen($firstname) < 2){
        $listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
    }elseif( !preg_match($regexName, $firstname) ){
        $listOfErrors[] = "Le prénom contient des caractères non autorisés";
    }

    // Vérifcation sur gender$gender
    $listOfGenders = ["m","f","o"];
    if(!in_array($gender, $listOfGenders)){
        $listOfErrors[] = "Le genre n'existe pas";
    }

    // Vérification des rôles 
    $listOfRoles = ["admin", "user", "vip"];
    if( !in_array($role, $listOfRoles) ){
        $listOfErrors[] = "Le rôle n'existe pas";
    }

    // Si l'Email est correcte
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
        $listOfErrors[] = "L'email est incorrect";
    }



    // Code à expliquer à partir d'ici : fait par fares 
    if(empty($listOfErrors)){

        $connect = connectDB();
        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER 
        SET nom=:nom, prenom=:prenom, email=:email, date_naissance=:date_naissance, 
        genre=:genre,ROLE_id_role=:id_role, date_modification=NOW() WHERE 
        id_user=:id_user");
        $queryPrepared->execute([
                                    "id_user"=>$id_user,
                                    "nom"=>$lastname,
                                    "prenom"=>$firstname,
                                    "email"=>$email,
                                    "date_naissance"=>$birthday,
                                    "genre"=>$gender,
                                    "id_role"=>$role

                                ]);
        header("Location: ../users.php");
    } else {
        //SI NOK
        //Redirection sur formulaire à modifier avec les erreurs
        $_SESSION['errors'] = $listOfErrors;
        header("Location: ../formModifyUser.php?id_user=$id_user&nom=$lastname&prenom=$firstname&date_naissance=$birthday&genre=$gender&email=$email&role=$role");                    
    }    
?>
