<!-- A corriger : fait par fares -->
<?php session_start();?>
<?php require "../core/functions.php"?>
<?php require "../core/conf.inc.php"?>
<?php include "../template/header.php"
?>

<?php
				if(!isAdmin()){
					header("location:../index.php");
				}

				if(!isset(	$_GET['id_user'],
							$_GET["nom"],
							$_GET["prenom"],
							$_GET["role"],
							$_GET["genre"],
							$_GET["date_naissance"],
							$_GET["email"])){

								header("location: users.php");

				}

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

<form action='traitements/modifyUser.php?id_user=<?php print_r($_GET['id_user'])?>' method="POST">
			
					
					<div class="row mb-4">
                        <div>
							<label for="nom" class="form-label">
							    Nom
							</label>
						</div>
                        <input class="form-control" type="number" hidden name="id_user" id="id_user" value="<?php print_r($_GET['id_user'])?>" required="required">
						<div class="align-items-center col-md-3">
                            
							<input class="form-control" type="text" name="nom" id="nom" value="<?php print_r($_GET["nom"])?>" required="required">
						</div>
						<div class="col-md-3">
							<input class="form-control" class="form-control" type="text" name="prenom" id="prenom" value="<?php print_r($_GET["prenom"])?>" required="required">
						</div>
                        <div class="col-md-6">
							<select name="role"  class="form-select">
								<option <?php if($_GET["role"]=='admin'){echo "selected";}?> value="admin">Admin</option>
								<option <?php if($_GET["role"]=='user'){echo "selected";}?> value="user">Utilisateur</option>
                                <option <?php if($_GET["role"]=='vip'){echo "selected";}?> value="vip">Utilisateur VIP</option>
							</select>
						</div>
                        
					</div>

					<div class="row mb-4">
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-3">
									<label for="birthday" class="form-label">
										Date de naissance
									</label>
								</div>
								<div class="col-md-6">
									<input class="form-control" type="date" id="birthday" name="date_naissance" value="<?php print_r($_GET["date_naissance"])?>" required="required">
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<select name="genre"  class="form-select">
								<option <?php if($_GET["genre"]=="m"){echo "selected";}?> value="m">M.</option>
								<option <?php if($_GET["genre"]=="f"){echo "selected";}?> value="f">Mme.</option>
								<option <?php if($_GET["genre"]=="o"){echo "selected";}?> value="o">Autre</option>
							</select>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<input class="form-control" type="email" name="email" value="<?php print_r($_GET["email"])?>" required="required">
							
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<label>
								<button class="btn btn-primary mb-4">Modifier</button>
							</label>
						</div>
					</div>
				</form>
