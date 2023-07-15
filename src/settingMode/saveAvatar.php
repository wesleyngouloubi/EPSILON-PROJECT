<?php
session_start();
require "../../core/conf.inc.php";
require "../../core/functions.php";



var_dump($_SESSION);
// Récupération de l'image en base64
$imageBase64 = $_POST['image'];
$email = $_SESSION['email'];

// Conversion de la représentation base64 en binaire
$imageBinary = base64_decode(str_replace('data:image/png;base64,', '', $imageBase64));

// Connexion à la base de données
$connect = connectDB();

// Requête d'insertion de l'image en base de données
$queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET img_avatar = :img_avatar WHERE email=:email");
// $queryPrepared->bindParam(":img_avatar", $imageBinary, PDO::PARAM_LOB);
$queryPrepared->execute([
    "email" => $email,
    "img_avatar" => $imageBase64
]);

// Vérification des erreurs
if ($queryPrepared->errorCode() !== '00000') {
    echo json_encode(false);

} else {
    echo json_encode(true);
}
?>
