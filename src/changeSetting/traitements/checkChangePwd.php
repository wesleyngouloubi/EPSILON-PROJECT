<?php
session_start();
require "../../../core/conf.inc.php";
require "../../../core/functions.php";


if( count($_POST) != 3
		|| empty($_POST["oldPwd"])
		|| empty($_POST["newPwd"])
        || empty($_POST["pwdConfirm"])
)
{
    header("location: /index.php");
}

$oldPwd = htmlspecialchars($_POST["oldPwd"]);
$newPwd = htmlspecialchars($_POST["newPwd"]);
$pwdConfirm = htmlspecialchars($_POST["pwdConfirm"]);
$email = $_SESSION["email"];

$connect = connectDB();
$queryPrepared = $connect->prepare("SELECT pwd FROM ".DB_PREFIX."USER WHERE email=:email");
$queryPrepared->execute([
    "email" => $email
]);

$result = $queryPrepared->fetch();


$pwd = $result["pwd"];
//pwdConfirm -> = Pwd
if(password_verify($pwd, $oldPwd)){
    $listOfErrors[] = "Votre mot de passe ne correspond pas";
}

//Pwd -> Min 8 caractères avec minuscules majuscules et chiffres
if( strlen($pwd)<8 || 
!preg_match("#[a-z]#", $pwd)  || 
!preg_match("#[A-Z]#", $pwd)  || 
!preg_match("#[0-9]#", $pwd) ){

    $listOfErrors[] = "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules et des chiifres";
}


//pwdConfirm -> = Pwd
if( $newPwd != $pwdConfirm ){
    $listOfErrors[] = "Votre mot de passe de confirmation ne correspond pas";
}

if(empty($listOfErrors)){
    // Connexion à la base de données
    $connect = connectDB();
    $newPwd = password_hash($newPwd,PASSWORD_DEFAULT);
    // Requête d'insertion de l'image en base de données
    $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET pwd=:newPwd WHERE email=:email");
    $queryPrepared->execute([
        "newPwd" => $newPwd,
        "email" => $_SESSION["email"]
    ]);

    $_SESSION["success"] = 1;
    header('location: ../changePassword.php');

}else{
    $_SESSION["errors"] = $listOfErrors;
    header('location: ../changePassword.php');
}
