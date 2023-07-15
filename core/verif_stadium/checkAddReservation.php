
<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
?>

<?php

// id du stade et durée de la réservation
$duration = $_GET["dur"];
$stadiumId = $_GET["stadium"];

// Concaténation de la date et de l'heure pour former une valeur datetime complète et l'entrer en base de donnée
$date_start = $_GET["date"] . ' ' . $_GET["start"];
$date_end = date('Y-m-d H:i:s', strtotime($date_start . ' +' .$duration . 'hours'));


$connect = connectDB();

//verif de la disponibilité du créneau
$queryPrepared = $connect->prepare("SELECT COUNT(*) AS count FROM RESERVATION WHERE date_heure_debut = :date_heure_debut AND date_heure_fin = :date_heure_fin");
$queryPrepared->execute([
    "date_heure_debut" => $date_start,
    "date_heure_fin" => $date_end
]);

$result = $queryPrepared->fetch();

if ($result['count'] > 0) {
    //si pas disponible
    $_SESSION["error"]=1;
    header("location: ../src/footballGame.php");
} else {
    //créneau dispo, on peut entrer la réservation en base de donnée
    $queryId = $connect->query("SELECT id_user FROM ".DB_PREFIX."USER WHERE email ='".$_SESSION["email"]."'");
    $id = $queryId->fetch();
    $queryPrepared = $connect->prepare("INSERT INTO RESERVATION(USER_id_user, date_heure_debut, date_heure_fin, STADIUM_id_stadium, date_reservation) VALUES (:id_user, :date_heure_debut, :date_heure_fin, :stade, NOW())");

    $queryPrepared->execute([
        "date_heure_debut" => $date_start,
        "date_heure_fin" => $date_end,
        "id_user" => $id["id_user"],
        "stade" => $stadiumId
]);

    if ($queryPrepared->rowCount() > 0) {
        //la réservation a été ajoutée avec succès en base de données
        $_SESSION["success"]=1;
        header("location: ../../src/stadium.php"); //pour l'instant redirection sur la page de reservation
    } else {
        //erreur s'est produite lors de l'insertion de la réservation
        $_SESSION["error"]=1;
        header("location: ../../src/stadium.php"); //pour l'instant redirection sur la page de reservation
    }
}