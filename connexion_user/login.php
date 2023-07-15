<!-- A commenter seulement -->
<link href="loginDesign.css" rel="stylesheet">
<?php 
	session_start(); 
	include "../template/header.php"; 
	include "../core/conf.inc.php";
	include "../core/functions.php";

	redirectIfAlreadyConnected();
	
	if (!empty($_SESSION['errors'])) {
		?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php
			foreach ($_SESSION['errors'] as $error) {
				echo "<li>" . $error . "</li>";
			}
			?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php
		unset($_SESSION['errors']);
	}
	
				
?>

<div class="row justify-content-center" id="bg-register">
	<div class="col-md-8" id="bg-form">
		<div class="row">
			<div class="col-12">
				<div class="m-6" id="text-bg" class="text-opacity">
					<h1><img src="/image/miniLogo.png" alt="Logo" width="50px"> Connexion Epsilon </h1> 
				</div>
											
				<form action="../core/useCaptcha/pageCaptcha.php" method="POST">
					<div class="row mb-4 justify-content-center">
						<div class="col-md-6"></div>
					</div>
					<div class="form-outline mb-4">
						<input type="email" class="form-control" name="email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ""; ?>">
						<label class="form-label">Adresse Mail</label>
					</div>
					<div class="form-outline mb-4 justify-content-center">
						<input type="password" class="form-control" name="pwdUser" autocomplete="off">
						<label class="form-label">Mot de passe</label>
					</div>
										
					<div class="text-center">
						<label>
							<button class="btn btn-primary btn-block mb-4">Se connecter</button>
						</label>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- <script type="text/javascript" src="registerAriane.js"></script> -->
<?php include "../template/footer.php"; ?>
