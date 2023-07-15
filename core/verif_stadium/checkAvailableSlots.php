<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
?>

<div class="container text-center">

<?php
$date = $_GET['date'];

// Récupérer la liste des stades
$stadiums = getStadiums();
?>
<div class="row">
<?php
foreach ($stadiums as $stadium) {
    $stadiumId = $stadium['id_stadium'];
    
    $stadiumPrice = $stadium['prix_heure'];

    echo '<div class="col md-4 mt-4">';
    echo '<h3>Terrain ' . $stadiumId . '</h3>';

    // Requête SQL préparée pour récupérer les réservations pour la date sélectionnée
    $connection = connectDB();
    $queryPrepared = $connection->prepare("SELECT date_heure_debut, date_heure_fin FROM RESERVATION WHERE STADIUM_id_stadium =:stadiumId AND DATE(date_heure_debut) = :date");
    $queryPrepared->execute([
        "date"=>$date,
        "stadiumId"=>$stadiumId
    ]);
    $reservedSlots = $queryPrepared->fetchAll();

    $availableSlots = array();
    $start_time = strtotime($date . ' 10:00:00');
    $end_time = strtotime($date . ' 18:00:00');

    // On ajoute tous les créneaux POSSIBLE (et non disponible, vérif étape d'après) de la journée à notre tableau 
    while ($start_time < $end_time) {
        $availableSlots[] = array(
            'start_time' => date('H:i', $start_time),
            'end_time' => date('H:i', strtotime('+1 hour', $start_time))
        );

        $start_time = strtotime('+1 hour', $start_time);
    }
    
    // On compare donc les slots réservés à nos slots possibles et on unset les créneaux réservés
    foreach ($reservedSlots as $reservation) {
        $start_reservation = strtotime($reservation['date_heure_debut']);
        $end_reservation = strtotime($reservation['date_heure_fin']);

        foreach ($availableSlots as $key => $slot) {
            $start_slot = strtotime($date . ' ' . $slot['start_time']);
            $end_slot = strtotime($date . ' ' . $slot['end_time']);

            if ($start_reservation < $end_slot && $end_reservation > $start_slot) {
                unset($availableSlots[$key]);
            }
        }
    } // Il nous reste donc dans availableSlots[] les créneaux disponibles

    // Vérification de la disponibilité des créneaux consécutifs pour une réservation de 2 heures
    $availableSlots = array_values($availableSlots);
    $availableSlots_2h = array();
    $nb_availableSlots = count($availableSlots);

    for ($i = 0; $i < $nb_availableSlots - 1; $i++) {
        if(!isset($availableSlots[$i])){
            continue;
        }

        $start_slot_1 = strtotime($date . ' ' . $availableSlots[$i]['start_time']);
        $end_slot_1 = strtotime($date . ' ' . $availableSlots[$i]['end_time']);
        $start_slot_2 = strtotime($date . ' ' . $availableSlots[$i + 1]['start_time']);
        $end_slot_2 = strtotime($date . ' ' . $availableSlots[$i + 1]['end_time']);

         // Vérifier si tous les créneaux entre le créneau initial et final sont disponibles
        $slotsAvailable = true;
        for ($j = $start_slot_1; $j < $end_slot_2; $j += 3600) {
            $current_slot = date('H:i', $j);
            $current_slot_end = date('H:i', strtotime('+1 hour', $j));

            foreach ($reservedSlots as $reservation) {
                $start_reservation = strtotime($reservation['date_heure_debut']);
                $end_reservation = strtotime($reservation['date_heure_fin']);
    
                if ($start_reservation < strtotime($date . ' ' . $current_slot_end) && $end_reservation > strtotime($date . ' ' . $current_slot)) {
                    $slotsAvailable = false;
                    break;
                }
            }
            // Si un créneau est réservé, arrêter la vérification
            if (!$slotsAvailable) {
                break;
            }
        }

        if ($slotsAvailable) {
            $availableSlots_2h[] = array(
                'start_time' => $availableSlots[$i]['start_time'],
                'end_time' => $availableSlots[$i + 1]['end_time']
            );
            }
        
    }


    // Génération des boutons de réservation
    $currentDateTime = strtotime(date('Y-m-d H:i:s'));
    foreach ($availableSlots as $slot) {
        $start_time = $slot['start_time'];
        if (strtotime($date . ' '. $start_time) < $currentDateTime) {
            continue; // Passez à la prochaine itération pour ignorer ce créneau
        }

        echo '<div>';
        echo '<p>Créneau disponible : ' . $start_time . '</p>';
        
        // Vérifier si un créneau de 1 heure est disponible
        echo '<a href="../core/verif_stadium/checkAddReservation.php?dur=1&start='.$start_time.'&date='.$date.'&stadium='.$stadiumId.'" class="m-2 btn btn-warning">Réserver 1h</a>';
        
        // Vérifier si un créneau de 2 heures est disponible
        $slot_2h = array_search($start_time, array_column($availableSlots_2h, 'start_time'));
        if ($slot_2h !== false) {
            echo '<a href="../core/verif_stadium/checkAddReservation.php?dur=2&start='.$start_time.'&date='.$date.'&stadium='.$stadiumId.'" class="m-2 btn btn-warning">Réserver 2h</a>';
        }
        
        echo '</div>';
    }
    echo '</div>';
}
    ?>
</div>
</div>
