<?php
	session_start();
	require "../core/conf.inc.php";
 	require "../core/functions.php";
    include "../template/header.php";
    include "../template/navbar.php";
?>

<!-- Classement TOP Equipe -->
<?php redirectIfNotConnected(); ?>
<div>
	<?php include "../core/signature.php" ?>
</div>

<?php include "../template/footer.php" ?> 