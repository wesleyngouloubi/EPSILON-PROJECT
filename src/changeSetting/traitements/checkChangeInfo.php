<?php
session_start();
require "../../core/conf.inc.php";
require "../../core/functions.php";


if( count($_POST) != 4
		|| empty($_POST["lastname"])
		|| empty($_POST["firstname"])
        || empty($_POST["email"])
        || empty($_POST["age"])
)
{
    die("Tentative de HACK !!!!");
}



$nom = htmlspecialchars(cleanLastname($_POST["nom"]));
$prenom = htmlspecialchars(cleanFirstname($_POST["prenom"]));
$email = htmlspecialchars(cleanEmail($_POST["email"]));

// Connexion à la base de données
$connect = connectDB();

// Requête d'insertion de l'image en base de données
$queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET email=:email, nom=:nom, prenom=:prenom WHERE email=:email");
$queryPrepared->execute([
    "email" => $email,
    "prenom"=>$prenom, 
    "nom"=>$nom
]);


$_SESSION['email'] = $email ;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;

header('location: infoPerso.php');