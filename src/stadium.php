<?php
	session_start();
	require "../core/conf.inc.php";
 	require "../core/functions.php";
?>


<?php include "../template/header.php"?>
<?php include "../template/navbar.php"?>

<?php 

			if(isset($_SESSION['success'])){
				unset($_SESSION['success']);
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					Réservation réalisée ! 
				</div>
				
<?php 		}elseif(isset($_SESSION['error'])){
				unset($_SESSION['error'])
?>				<div class="alert alert-success alert-dismissible fade show" role="alert">
					Réservation échouée ! 
				</div>	

<?php		}
// ne pas oublier il faudra préciser et expliquer l'erreur à l'utilisateur
?>

<?php

redirectIfNotConnected();
//on récupére de la date actuelle
$currentDate = strtotime('today');

//on calcul de la date de début et de fin des deux prochaines semaines
$startDate = $currentDate; // Utiliser la date actuelle comme date de début
$endDate = strtotime('+2 weeks', $currentDate);

//itération sur chaque jour et génération des boutons correspondants
echo '<h2 class="">Choisissez une date :</h2>';
echo '<div class="date-buttons">';

for ($date = $startDate; $date <= $endDate; $date = strtotime('+1 day', $date)) {
    $dayOfWeek = date('D', $date); // Jour de la semaine (abrégé)
    $dayOfMonth = date('j', $date); // Jour du mois (chiffre)
    $month = date('M', $date); // Mois (abrégé)

    //génération du bouton pour chaque jour avec les classes de Bootstrap
    echo '<button class="mx-2 btn btn-warning date-button" onclick="loadCreneaux(\'' . date('Y-m-d', $date) . '\')">';
    echo '<div class="date-button-weekday">' . $dayOfWeek . '</div>';
    echo '<div class="date-button-day">' . $dayOfMonth . '</div>';
    echo '<div class="date-button-month">' . $month . '</div>';
    echo '</button>';
	}
echo '</div>';
?>
<div id="creneaux-disponibles"></div>

<script>
function loadCreneaux(date) {
    //création de l'objet XMLHttpRequest
    var xhr = new XMLHttpRequest();

    //définition de la fonction de rappel pour le traitement de la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            //mise à jour du contenu de la balise div avec les créneaux disponibles
            document.getElementById("creneaux-disponibles").innerHTML = xhr.responseText;
        }
    };

    //construction de l'URL de la requête avec la date sélectionnée
    var url = "../core/verif_stadium/checkAvailableSlots.php?date=" + encodeURIComponent(date);

    // Envoi de la requête AJAX
    xhr.open("GET", url, true);
    xhr.send();
}
</script>
<?php include "../template/footer.php" ?> 