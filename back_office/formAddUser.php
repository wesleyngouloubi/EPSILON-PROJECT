<?php session_start();?>

<?php require "../core/functions.php" ?>
<?php require "../core/conf.inc.php" ?>
<?php include "../template/header.php"?>

<?php

	if(!isAdmin()){
		header("location:../index.php");
	}

	function saved($key){
		if(!empty($_GET)){
			echo "value='".$_GET[$key]."'";
		}
	}
?>

<?php
           
    if(!empty($_SESSION['errors'])){
?>
				 	

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php 
        foreach($_SESSION['errors'] as $error){
        echo "<li>".$error."</li>";
        }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php
    unset($_SESSION['errors']);
    
	}

?>

<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="row">
			<div class="col-12">
				<h1 class="m-4">Ajouter un nouvel utilisateur</h1>

				<form action="traitements/addNewUser.php" method="POST">
					
					<div class="row mb-4">
						<div class="col-md-6">
							<input class="form-control" type="text" name="nom" id="nom" placeholder="Son nom" required="required" <?php saved($key='nom')?>>
						</div>
						<div class="col-md-6
						">
							<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Son prénom" required="required" <?php saved($key='prenom')?>>
						</div>
					</div>
                    <div class="col-md-12 mb-4"> 
							<select name="role"  class="form-select">
								<option <?php if(!empty($_GET["role"])&& $_GET["role"]==="admin"){echo"selected";}?>value="admin">Admin</option>
								<option <?php if(!empty($_GET["role"])&& $_GET["role"]==="user"){echo"selected";}?> value="user" selected>Utilisateur</option>
                                <option <?php if(!empty($_GET["role"])&& $_GET["role"]==="vip"){echo"selected";}?> value="vip">Utilisateur VIP</option>
							</select>
						</div>

					<div class="row mb-4">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<label for="birthday" class="form-label">
										Sa date de naissance :
									</label>
								</div>
								<div class="col-md-6">
									<input class="form-control" type="date" id="birthday" name="date_naissance" placeholder="Sa date de naissance" required="required" <?php saved($key='date_naissance')?>>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<select name="genre"  class="form-select">
								<option <?php if(!empty($_GET["genre"])&& $_GET["genre"]==="m"){echo"selected";}?> value="m">M.</option>
								<option <?php if(!empty($_GET["genre"])&& $_GET["genre"]==="f"){echo"selected";}?> value="f">Mme.</option>
								<option <?php if(!empty($_GET["genre"])&& $_GET["genre"]==="o"){echo"selected";}?> value="o">Autre</option>
							</select>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<input class="form-control" type="email" name="email" placeholder="Son email" required="required" <?php saved($key='email')?>>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<input class="form-control" type="password" name="pwd" placeholder="Son mot de passe" required="required">
						</div>
						<div class="col-md-6">
							<input class="form-control" type="password" name="pwdConfirm" placeholder="Confirmation" required="required">
						</div>
						
					</div>
					<div class="row mb-4">
						
					</div>

					<div class="row">
						<div class="col-md-12 text-center">
							<label>
								<button class="btn btn-primary mb-4">Ajouter</button>
							</label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include "../template/footer.php" ?>