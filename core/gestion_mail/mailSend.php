<?php 

session_start(); 
require "../../template/header.php";
require "../conf.inc.php";
require "../functions.php";


$connect = connectDB();
$cle_auth = verificateMail();
$sender = $_SESSION['email'];
$senderName = $_SESSION['firstname'];
$subject = 'Vérification Mail EPSYLON';

$body = '<html><body style="background-color: yellow;">';
$body .= '<h1>Bienvenue, '.$senderName.' !</h1>';
$body .= '<p>Merci de vous être inscrit sur notre plateforme.</p>';
$body .= '<p>Pour pouvoir vous connecter, veuillez valider votre compte en cliquant sur le lien ci-dessous :</p>';
$body .= '<p><a href="https://epsilon.best/core/gestion_mail/mailVerify.php?cle_auth='.$cle_auth.'">Cliquez ici pour activer votre compte</a></p>';
$body .= '<p>Si vous ne parvenez pas à cliquer sur le lien, veuillez copier et coller l\'URL dans la barre d\'adresse de votre navigateur.</p>';
$body .= '<p>Nous vous remercions de votre confiance et restons à votre disposition.</p>';
$body .= '</body></html>';


require "mail.php";

if(empty($error)) {
  //Insertion du USER en bdd
  $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET tokens_mail=:cle_valeur WHERE email=:sender");

  $queryPrepared->execute([
    "cle_valeur"=>$cle_auth,
    "sender"=>$sender
  ]);
}

?>

<link href="mail.css" rel="stylesheet">

<div class="animation-container">
  <div class="circle">
    <span class="emoji">✅</span>
  </div>
</div>


<div id="design">
    Merci beaucoup pour votre inscription,<br>
    Veuillez vérifier votre email (dans les spams égalements)<br><br>

    Après avoir validé votre compte : <a href="../../connexion_user/login.php"> Se connecter</a>
</div>





