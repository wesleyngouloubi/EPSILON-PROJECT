<?php
	session_start();
  require "../../core/conf.inc.php";
 	require "../../core/functions.php";
?>
<link href="myTeam.css" rel="stylesheet">
<?php include "../../template/header.php"?>
<?php include "../../template/navbar.php"?>


<?php
print_r($_SESSION);
redirectIfNotConnected();
$team = whichTeam();
$connect = connectDB();
$leaderQuery = $connect->prepare("SELECT EPSFWK_USER.email
  FROM EPSFWK_USER
  JOIN TEAM ON EPSFWK_USER.id_user = TEAM.createur_id
  WHERE TEAM.id_team = :id_team");

$leaderQuery->execute(["id_team"=>$team["id_team"]]);
$leader = $leaderQuery->fetch();

if($leader["email"] != $_SESSION["email"]){
  header("location: myTeam.php");
}



if(!empty($team)){
	$teamName = $team["nom_equipe"];
	$membersQuery = $connect->prepare("SELECT id_user, nom, prenom, email FROM ".DB_PREFIX."USER WHERE TEAM_id_team = :team_id");
	$membersQuery->execute(["team_id"=>$team["id_team"]]);
	$listOfMembers = $membersQuery->fetchAll();

  $leaderQuery = $connect->prepare("SELECT email FROM ".DB_PREFIX."USER, TEAM WHERE TEAM_id_team = :id_team AND createur_id = EPSFWK_USER.id_user");
  $leaderQuery->execute(["id_team"=>$team["id_team"]]);
  $leader = $leaderQuery->fetch();
  
  ?>
  <script>
    function copy() {
    const inputKey = document.getElementById('myKey');
    console.log(inputKey);
    inputKey.select();
    document.execCommand('copy');
    alert('Ta clé a été copié dans ton presse-papier et est prête à être partagée !');
    }
  </script>

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
          <label>
            <div class="text-warning">Clé d'invitation : transmet la à tes amis pour qu'ils rejoignent ton équipe !</div>
          <input class="form-control my-2" type="text" value="<?=$team["cle_invitation"]?>" id="myKey" readonly>
          <button class="btn btn-warning my-2" onclick='copy()'>Copier</button>
            <h5 class="text-dark">Joueurs de l'équipe :</h5>
            <ul class="list-group">
              <?php foreach ($listOfMembers as $member) { ?>
                <li class="list-group-item text-warning">
                  <?php 
                    if($leader["email"] == $member["email"]){
                      echo $member["prenom"] . ' (Fondateur)';
                    }else{
                      echo $member["prenom"];?>
                      <a href="traitements/checkKickTeam.php?i=<?=$member["id_user"]?>" class="btn btn-danger " onclick="return confirm('Vous êtes sûr de vouloir exclure <?=$member['prenom']?> ?')">Exclure</a>
                    <?php } ?>
                </li>
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
      <a href="createTeam.php" class="btn btn-warning"><i class="fas fa-users"></i>Créer une équipe</a>
    </div>
  </div>

<?php }?>
<?php include "../../template/footer.php" ?>