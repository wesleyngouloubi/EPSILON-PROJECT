
<?php	
	require "../../vendor/autoload.php";
	use Dompdf\Dompdf;
	session_start();
	require "../../core/conf.inc.php";
 	require "../../core/functions.php";
   	include "../../template/header.php";
    include "../../template/navbar.php";

	redirectIfNotConnected();
	
	$email = $_SESSION['email'];
	$lastname = $_SESSION['nom'];
	$firstname = $_SESSION['prenom'];


	

	//Insertion du USER en bdd
	$connect = connectDB(); 
	$queryPrepared = $connect->prepare("SELECT img_avatar FROM ".DB_PREFIX."USER WHERE email=:email");
	$queryPrepared->execute(["email" => $email]);

	$result = $queryPrepared->fetch();

	if(isset($_GET['getData'])) {


		ob_end_clean();
		$query = $connect->query('SELECT nom, prenom, genre, email, phone, date_naissance FROM '.DB_PREFIX.'USER WHERE email="'.$email.'"');
		$data = $query->fetch();

		$html = '
		<center>
			<table>
				<tbody>
					<tr>
						<th scope="row">nom</th>
						<td>'.$data['nom'].'</td>
					</tr>
					<tr>
						<th scope="row">prenom</th>
						<td>'.$data['prenom'].'</td>
						
					</tr>
					<tr>
						<th scopte="row">genre</th>
						<td>'.$data['genre'].'</td>
					</tr>

					<tr> 
						<th scope="row">email</th>
						<td>'.$data['email'].'</td>
					</tr>
					<tr>
						<th scope="row">phone</th>
						<td>'.$data['phone'].'</td>
	
					</tr>

					<tr>
						<th scope="row">date_naissance</th>
						<td>'.$data['date_naissance'].'</td>
					</tr>

				</tbody>
			</table>
		</center>';

		$dompdf = new Dompdf();
        	$dompdf->getOptions()->set('defaultFont', 'Arial');
        	$dompdf->setPaper('A4', 'portrait');
        	$dompdf->loadHtml($html);
		$dompdf->render();
		$dompdf->stream("export_de_donnees.pdf", array("Attachment" => 1));
        	exit;
	}
?>

<link href="settingUser.css" rel="stylesheet">

<!-- Paramétre User -->

<div>
	<div class="main-body">

		<div class="row gutters-sm">

			<div class="col-md-4 mb-3">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<?php 
							if ($result && $result['img_avatar']) {
								$img_avatar = $result['img_avatar'];
								?>
									<img src="<?php echo $img_avatar; ?>" alt="image-avatar" class="rounded-circle" width="150">
									<div class="mt-3">
										
									<a href="deleteAvatar.php" class="btn btn-danger">Supprimer</a>
								<?php
							} else {
								// Utiliser une image par défaut si aucun avatar n'est trouvé
								$img_avatar = '../../image/avatar7.png';
								?>
									<img src="<?php echo $img_avatar; ?>" alt="image-avatar" class="rounded-circle" width="150">
									<div class="mt-3">
								<?php
								
							}
							?>
							
							<a href="avatarModify.php" class="btn btn-primary">Modifier</a>

							<div id="text-avatar">
								<h4 class="text-secondary"><?php echo $firstname;?> <?php echo $lastname; ?></h4>
								<p class="text-secondary mb-1"><?php echo $email; ?></p>
								<p class="text-muted font-size-sm">Phrase du jour : </p>
							</div>
							<form>
								<button class="btn btn-primary" name="getData" value="1">Récupérer ses données</button>
							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="card mt-3">
				
			</div>
		</div>

		<div class="col-md-8">
			<div class="card mb-3">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3">
							<h6 class="mb-0 text-secondary">Badge</h6>
						</div>
					</div>
				</div>	
			</div>
		</div>

	</div>
</div>


<?php include "../../template/footer.php" ?> 
