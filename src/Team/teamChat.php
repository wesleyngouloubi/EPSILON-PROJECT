<?php
	session_start();
  require "../../core/conf.inc.php";
 	require "../../core/functions.php";
?>

<?php include "../../template/header.php"?>
<?php include "../../template/navbar.php"?>

<?php

redirectIfNotConnected();
redirectIfHaveNotTeam();

$connect = connectDB();

$queryPrepared1 = $connect->prepare("SELECT TEAM_id_team FROM ".DB_PREFIX."USER WHERE email = :email");
$queryPrepared1->execute(["email"=>$_SESSION['email']]);
$team = $queryPrepared1->fetchColumn();

$queryPrepared2 = $connect->prepare("SELECT tc.contenu_message, tc.date_emission, u.prenom
                                    FROM TEAM_CHAT tc
                                            JOIN EPSFWK_USER u ON u.id_user = tc.USER_id_user
                                            JOIN TEAM t ON t.id_team = u.TEAM_id_team
                                    WHERE tc.TEAM_id_team_tc = :id_team ORDER BY tc.date_emission DESC");
$queryPrepared2->execute(["id_team"=>$team]);
$teamChat = $queryPrepared2->fetchAll();
?>

<div class="navbar navbar-expand-lg">
    <div class="container-fluid">

      <div class="navbar-brand col-md text-center">
        <a href="myTeam.php" class="btn btn-block text-warning">Retour à Mon équipe</a>
      </div>

    </div>
</div>

<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 mt-5">
        <div class="card bg-dark text-light">
          <div class="card-header text-warning">
            Messagerie de l'équipe : 
          </div>
          <div class="card-body text-warning overflow-auto" style="height: 500px;">
            <?php foreach ($teamChat as $msg){?>
                <div class="d-flex align-items-baseline mb-4">
                    <div class="pe-2">
                        <div>
                            <div class="small"><?php ($msg["prenom"]==$_SESSION["prenom"]) ? print 'Vous' : print $msg["prenom"]; ?></div>
                        </div>
                        <div>
                            <div class="card card-text text-dark d-inline-block p-2 px-3 m-1"><?php echo $msg["contenu_message"]?></div>
                        </div>
                        <div>
                            <div class="small"><?php echo $msg["date_emission"]?></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
          </div>
          <div class="card-footer">
            <form action="traitements/checkAddNewMsg.php" method="POST">
              <div class="input-group">
                <input type="text" class="form-control" name ="msg" placeholder="Écrivez votre message ici...">
                <div class="input-group-append">
                  <button class="btn btn-warning" type="submit">Envoyer</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    setInterval(function() {
    location.reload();
    }, 15000);
  </script>
  <?php include "../../template/footer.php" ?>