<?php
  require "../../template/header.php";
  session_start();
  require "../../core/conf.inc.php";
  require "../../core/functions.php";
  include "../../template/navbar.php";

  redirectIfNotConnected();

  $email = $_SESSION['email'];
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];

?>

<link href="parametre.css" rel="stylesheet">


<div class="column">
    <?php include "navbarSetting.php"; ?>
    <section id="content">

        <section id="personal-info" >

            <h2>Informations personnelles</h2>
            <form action="traitements/checkChangeInfo.php" method="POST">
                <div>
                    Nom :  <input type="text" name="nom" value="<?php echo $nom; ?>">
                </div>
                <div>
                    Prénom :  <input type="text" name="prenom" value="<?php echo $prenom; ?>">
                </div>
                <div>
                    Mail :  <input type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div>
                    <button class="btn btn-primary mt-4">Enregistrer les modifications</button>
                </div>
            </form>

        </section>

        

    </section>
</div>
<?php include "../../template/footer.php"; ?>
<script src="settingMode.js"></script>

