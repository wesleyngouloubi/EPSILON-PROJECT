<?php
	session_start();
  require "../../core/conf.inc.php";
 	require "../../core/functions.php";
?>
<link href="myTeam.css" rel="stylesheet">
<?php include "../../template/header.php"?>
<?php include "../../template/navbar.php"?>


<?php
redirectIfNotConnected();

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


$team = whichTeam();

if(!empty($team)){
	$teamName = $team["nom_equipe"];
  $connect = connectDB();
	$membersQuery = $connect->prepare("SELECT nom, prenom, email FROM ".DB_PREFIX."USER WHERE TEAM_id_team = :team_id");
	$membersQuery->execute(["team_id"=>$team["id_team"]]);
	$listOfMembers = $membersQuery->fetchAll();

  $leaderQuery = $connect->prepare("SELECT EPSFWK_USER.email
  FROM EPSFWK_USER
  JOIN TEAM ON EPSFWK_USER.id_user = TEAM.createur_id
  WHERE TEAM.id_team = :id_team");

  $leaderQuery->execute(["id_team"=>$team["id_team"]]);
  $leader = $leaderQuery->fetch();
  
  ?>
  <div class="navbar navbar-expand-lg">
    <div class="container-fluid">

      <div class="navbar-brand col-md text-center">
        <a href="myTeam.php" class="btn btn-block text-warning">Mon équipe</a>
      </div>

      
      <div class="navbar-brand col-md text-center">
        <a href="teamChat.php" class="btn btn-block text-warning">Messagerie</a>
      </div>

      <?php if($leader["email"]==$_SESSION["email"]){?>
              <div class="navbar-brand col-md text-center">
              <a href="manageMyTeam.php" class="btn btn-block text-warning">Gérer l'équipe</a>
              </div>
      <?php }?>

    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <br>
		    <h2 class="text-center">Mon équipe</h2> 
        <div class="card">
          <div class="card-header">
            <h4 class="text-dark text-center">Nom de l'équipe : <?php echo $teamName; ?></h4>
          </div>
          <div class="card-body">
            <h5 class="text-dark">Joueurs de l'équipe :</h5>
            <ul class="list-group">
              <?php foreach ($listOfMembers as $member) { ?>
                <li class="list-group-item text-warning">
                  <?php 
                    echo $member["prenom"];
                    if($leader["email"] == $member["email"]){
                      echo ' (Fondateur)';
                    }

                  ?></li>
              <?php } ?>
            </ul>
            <a href="traitements/checkLeaveTeam.php?i=<?=$team["id_user"]?>" class="btn btn-danger my-2" onclick="return confirm('Vous êtes sur le point de quitter votre équipe, êtes vous sûr ?')">Quitter</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }else{?>
  <div id="bg-equipe">
    <div class="container">
      <h2>Pas encore d'équipe ?</h2>
      <a href="createTeam.php" class="btn btn-warning">Créer une équipe</a> <br>
      <a href="joinTeam.php" class="btn btn-warning my-2">Rejoindre une équipe</a>
    </div>
  </div>
<?php }?>
<?php include "../../template/footer.php" ?>