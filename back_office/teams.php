
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
					L'équipe à bien été supprimée
				</div>
<?php 		}?>

<h1 class="text-center">Toutes les équipes</h1>
<input type="text" id="mySearch" placeholder="Rechercher une équipe" onkeyup="searchByThird()">

<?php
	
	$connect = connectDB();
	
	if(empty($_GET)){
		$results = $connect->query("SELECT TEAM.*, ".DB_PREFIX."USER.nom as nom_createur 
		FROM TEAM
		JOIN ".DB_PREFIX."USER ON TEAM.createur_id = ".DB_PREFIX."USER.id_user 
		ORDER BY date_creation DESC");
		
	}else{
		$sort = $_GET['sort'];
		$order = $_GET['order'];

		//vérification que la colonne à trier existe par sécurité
		$allowedSort = ["id_team", "createur_id", "nom", "nom_createur", "cle_invitation", "date_creation"];
		if(!in_array($sort, $allowedSort)){
			$sort = "date_creation"; //par défaut si colonne à trier demandé non existante
		}
		//vérification si l'ordre de tri existe par sécurité
		$allowedOrder = ["ASC", "DESC"];
		if(!in_array($order, $allowedOrder)){
			$order = "DESC"; //par défaut si ordre de tri demandé non existant
		}

		$results = $connect->query("SELECT TEAM.*, ".DB_PREFIX."USER.nom as nom_createur 
		FROM TEAM 
		JOIN ".DB_PREFIX."USER ON TEAM.createur_id = ".DB_PREFIX."USER.id_user 
		ORDER BY $sort $order");
	
	
	}
	$listOfteamss = $results->fetchAll();
	//fonction qui génère l'URL des boutons de tri pour permettre de faire l'action inverse après chaque clic
	function reverseOrderUrl($sortValue){
		$orderValue = isset($_GET['order']) ? $_GET['order'] : '';
    	$url = "?sort=$sortValue&order=" . ($orderValue === 'ASC' ? 'DESC' : 'ASC');
    	echo $url;
	}
	
?>
	<div>
	<table class="table" id="table">
		<thead>
			<tr>
				<th>id<a href="teams.php<?php reverseOrderUrl($sortValue='id_team');?>" class="btn btn-warning btn-sm">Tri</a></th>
				<th>id fondateur<a href="teams.php<?php reverseOrderUrl($sortValue='createur_id');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Nom équipe<a href="teams.php<?php reverseOrderUrl($sortValue='nom');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Nom fondateur<a href="teams.php<?php reverseOrderUrl($sortValue='nom_createur');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Clé d'invitation<a href="teams.php<?php reverseOrderUrl($sortValue='cle_invitation');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date de création<a href="teams.php<?php reverseOrderUrl($sortValue='date_creation');?>" class="btn btn-warning btn-sm">Tri</a> </th>
                <th>Action</th>
		
			</tr>
		</thead>
		<tbody>
			<?php

				foreach($listOfteamss as $teams){
					echo "<tr>";

					echo "<td>".$teams["id_team"]."</td>";
					echo "<td>".$teams["createur_id"]."</td>";
					echo "<td>".$teams["nom"]."</td>";
					echo "<td>".$teams["nom_createur"]."</td>";
					echo "<td>".$teams["cle_invitation"]."</td>";
					echo "<td>".$teams["date_creation"]."</td>";
					echo "<td>
							<a href='traitements/removeTeam.php?id_team=".$teams["id_team"]."' class='btn btn-danger'>Supprimer</a>
						</td>";

					echo "</tr>";
				}

			?>
		</tbody>
	</table>
	<div>
	<script src="functionsFilter.js">
<?php include "../template/footer.php" ?>