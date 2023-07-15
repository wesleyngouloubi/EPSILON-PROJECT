<?php
  session_start();
  require "../../core/conf.inc.php";
  require "../../core/functions.php";
?>



<?php include "../../template/header.php"?>
<?php include "../../template/navbar.php"?>
<?php
redirectIfNotConnected();
redirectIfHaveTeam();
?>

<link href="createTeam.css" rel="stylesheet">


<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="row">
			<div class="col-12">
				<h1 class="m-4 text-center">Créer une équipe</h1>
				<form action="traitements/checkAddNewTeam.php" method="POST" class="team-form">
				<div class="row mb-4 justify-content-center">
					<div class="col-md-6"></div>
				</div>
				<div class="form-outline mb-4">
					<input type="text" class="form-control" name="team" id="team-name">
					<label class="form-label" for="team-name">Nom de l'équipe</label>
				</div>        
				<div class="text-center">
					<button class="btn btn-warning btn-block mb-4" type="submit">Créer</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php include "../../template/footer.php" ?>
