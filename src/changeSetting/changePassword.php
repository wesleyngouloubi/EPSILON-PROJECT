<?php
  require "../../template/header.php";
  session_start();
  require "../../core/conf.inc.php";
  require "../../core/functions.php";
  include "../../template/navbar.php";

  redirectIfNotConnected();




        if(isset($_SESSION['success'])){
          unset($_SESSION['success']);
?>
         <div class="alert alert-success alert-dismissible fade show" role="alert">
            Votre mot de passe a bien été modifié
         </div>
<?php   }
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

<link href="parametre.css" rel="stylesheet">


<div class="column">
    <?php include "navbarSetting.php"; ?>
    <section id="content">

        <section id="change-password">
            <h2>Modifier mon mot de passe</h2>
            <form action="traitements/checkChangePwd.php" method="POST">
                <label for="oldPwd">Mot de passe actuel :</label>
                <input type="password" id="oldPwd" name="oldPwd" class="form-control">

                <label for="newPwd">Nouveau mot de passe :</label>
                <input type="password" id="newPwd" name="newPwd" class="form-control">

                <label for="pwdConfirm">Confirmer le nouveau mot de passe :</label>
                <input type="password" id="pwdConfirm" name="pwdConfirm" class="form-control">

                <button class="btn btn-warning mt-4" type="submit">Enregistrer</button>
            </form>

        </section>
    </section>
</div>
<?php include "../../template/footer.php"; ?>
<script src="settingMode.js"></script>