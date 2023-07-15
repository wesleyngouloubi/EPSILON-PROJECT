
<?php 
	session_start();
	require "../core/conf.inc.php";
	require "../core/functions.php";
?>

<?php 
	include "../template/header.php";
	include "../template/navbarBack.php";
?>

				
<?php 		
	
	if(!isAdmin()){
		header("location:../index.php");
	}


			if(isset($_SESSION['successRemove'])){
				unset($_SESSION['successRemove']);
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					La réservation à bien été supprimée
				</div>
<?php 		}?>

<h1 class="text-center">Toutes les réservations</h1>
<input type="text" id="mySearch" placeholder="Rechercher par son nom" onkeyup="searchByThird()">

<?php
	
	$connect = connectDB();
	
	if(empty($_GET)){
		$results = $connect->query("SELECT RESERVATION.*, ".DB_PREFIX."USER.nom
		FROM RESERVATION
		JOIN ".DB_PREFIX."USER ON RESERVATION.USER_id_user = ".DB_PREFIX."USER.id_user ORDER BY date_reservation DESC;");
		
	}else{
		$sort = $_GET['sort'];
		$order = $_GET['order'];

		//vérification que la colonne à trier existe par sécurité
		$allowedSort = ["id_reservation", "USER_id_user", "date_heure_debut", "date_heure_fin", "STADIUM_id_stadium", "date_reservation"];
		if(!in_array($sort, $allowedSort)){
			$sort = "date_reservation"; //par défaut si colonne à trier demandé non existante
		}
		//vérification si l'ordre de tri existe par sécurité
		$allowedOrder = ["ASC", "DESC"];
		if(!in_array($order, $allowedOrder)){
			$order = "DESC"; //par défaut si ordre de tri demandé non existant
		}

		$results = $connect->query("SELECT RESERVATION.*, ".DB_PREFIX."USER.nom
		FROM RESERVATION
		JOIN ".DB_PREFIX."USER ON RESERVATION.USER_id_user = ".DB_PREFIX."USER.id_user ORDER BY $sort $order");
	
	
	}
	$listOfReservations = $results->fetchAll();
	//fonction qui génère l'URL des boutons de tri pour permettre de faire l'action inverse après chaque clic
	function reverseOrderUrl($sortValue){
		$orderValue = isset($_GET['order']) ? $_GET['order'] : '';
    	$url = "?sort=$sortValue&order=" . ($orderValue === 'ASC' ? 'DESC' : 'ASC');
    	echo $url;
	}
	
?>
	<div>
	<table class="table">
		<thead>
			<tr>
				<th>id<a href="reservations.php<?php reverseOrderUrl($sortValue='id_reservation');?>" class="btn btn-warning btn-sm">Tri</a></th>
				<th>id user<a href="reservations.php<?php reverseOrderUrl($sortValue='USER_id_user');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Nom<a href="reservations.php<?php reverseOrderUrl($sortValue='nom');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date et heure debut<a href="reservations.php<?php reverseOrderUrl($sortValue='date_heure_debut');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date et heure fin<a href="reservations.php<?php reverseOrderUrl($sortValue='date_heure_fin');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Stade<a href="reservations.php<?php reverseOrderUrl($sortValue='STADIUM_id_stadium');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date de réservation<a href="reservations.php<?php reverseOrderUrl($sortValue='date_reservation');?>" class="btn btn-warning btn-sm">Tri</a> </th>
                <th>Action</th>
		
			</tr>
		</thead>
		<tbody>
			<?php

				foreach($listOfReservations as $reservation){
					echo "<tr>";

					echo "<td>".$reservation["id_reservation"]."</td>";
					echo "<td>".$reservation["USER_id_user"]."</td>";
					echo "<td>".$reservation["nom"]."</td>";
					echo "<td>".$reservation["date_heure_debut"]."</td>";
					echo "<td>".$reservation["date_heure_fin"]."</td>";
					echo "<td>".$reservation["STADIUM_id_stadium"]."</td>";
					echo "<td>".$reservation["date_reservation"]."</td>";
					echo "<td>
							<a href='traitements/removeReservation.php?id_reservation=".$reservation["id_reservation"]."' class='btn btn-danger'>Supprimer</a>
						</td>";

					echo "</tr>";
				}

			?>
		</tbody>
	</table>
	<div>
	<script src="functionsFilter.js">
<?php include "../template/footer.php" ?>