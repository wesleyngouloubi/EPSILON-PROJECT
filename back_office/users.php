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


			if(isset($_SESSION['successAdd'])){
				unset($_SESSION['successAdd']);
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					L'utilisateur à bien été ajouté
				</div>
				
<?php 		}
			if(isset($_SESSION['successRemove'])){
				unset($_SESSION['successRemove']);
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					L'utilisateur à bien été supprimé
				</div>
<?php 		}
			if(isset($_SESSION['successModify']	)){
				unset($_SESSION['successModify']);
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					L'utilisateur à bien été modifié
				</div>
<?php 		}
?>






<h1 class="text-center">Tous les utilisateurs</h1>

<a href="formAddUser.php" class="position-relative mb-4 start-50 translate-middle-x btn btn-warning">Ajouter</a>

<div>
<input type="text" id="mySearch" placeholder="Rechercher par son nom" onkeyup="searchBySecond()">
</div>


<?php
	
	$connect = connectDB();
	
	if(empty($_GET)){
		$results = $connect->query("SELECT * FROM ".DB_PREFIX."USER ORDER BY id_user DESC");
		
	}else{
		$sort = $_GET['sort'];
		$order = $_GET['order'];

		//vérification que la colonne à trier existe par sécurité
		$allowedSort = ["id_user", "nom", "prenom", "email", "date_naissance", "genre", "pays", "role", "date_creation", "date_modification"];
		if(!in_array($sort, $allowedSort)){
			$sort = "id_user"; //par défaut si colonne à trier demandé non existante
		}
		//vérification si l'ordre de tri existe par sécurité
		$allowedOrder = ["ASC", "DESC"];
		if(!in_array($order, $allowedOrder)){
			$order = "DESC"; //par défaut si ordre de tri demandé non existant
		}

		$results = $connect->query("SELECT * FROM ".DB_PREFIX."USER ORDER BY $sort $order");
	
	
	}
	$listOfUsers = $results->fetchAll();
	
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
				<th>id<a href="users.php<?php reverseOrderUrl($sortValue='id_user');?>" class="btn btn-warning btn-sm">Tri</a></th>
				<th>Nom<a href="users.php<?php reverseOrderUrl($sortValue='nom');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Prénom<a href="users.php<?php reverseOrderUrl($sortValue='prenom');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Email<a href="users.php<?php reverseOrderUrl($sortValue='email');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date de naissance<a href="users.php<?php reverseOrderUrl($sortValue='date_naissance');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Genre<a href="users.php<?php reverseOrderUrl($sortValue='genre');?>" class="btn btn-warning btn-sm">Tri</a> </th>
                <th>Rôle<a href="users.php<?php reverseOrderUrl($sortValue='ROLE_id_role');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date de création<a href="users.php<?php reverseOrderUrl($sortValue='date_creation');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Date de modification<a href="users.php<?php reverseOrderUrl($sortValue='date_modification');?>" class="btn btn-warning btn-sm">Tri</a> </th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php

				foreach($listOfUsers as $user){
					echo "<tr>";

					echo "<td>".$user["id_user"]."</td>";
					echo "<td>".$user["nom"]."</td>";
					echo "<td>".$user["prenom"]."</td>";
					echo "<td>".$user["email"]."</td>";
					echo "<td>".$user["date_naissance"]."</td>";
					echo "<td>".$user["genre"]."</td>";
					echo "<td>".$user["ROLE_id_role"]."</td>";
					echo "<td>".$user["date_creation"]."</td>";
					echo "<td>".$user["date_modification"]."</td>";
					echo "<td>
							<a href='traitements/removeUser.php?id_user=".$user["id_user"]."' class='btn btn-danger'>Supprimer</a>
							<a class='btn btn-primary' onclick='return confirm('Oui?')' href='formModifyUser.php?nom=".$user["nom"].
																"&prenom=".$user["prenom"].
																"&email=".$user["email"].
																"&date_naissance=".$user["date_naissance"].
																"&genre=".$user["genre"].
																"&role=".$user["ROLE_id_role"].
																"&id_user=".$user["id_user"]."'>Modifier</a>

						</td>";

					echo "</tr>";
				}

			?>
		</tbody>
	</table>
	<div>
	<script src="functionsFilter.js">

<?php include "../template/footer.php" ?>