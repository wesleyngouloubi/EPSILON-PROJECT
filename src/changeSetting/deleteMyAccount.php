<?php
  require "../../template/header.php";
  session_start();
  require "../../core/conf.inc.php";
  require "../../core/functions.php";
  include "../../template/navbar.php";

  redirectIfNotConnected();
?>

<link href="parametre.css" rel="stylesheet">

<div class="column">
    <?php include "navbarSetting.php"; ?>
    <section id="content">

      <section >
          <h2>Supprimer mon compte</h2>
          <p>En cliquant sur le bouton ci-dessous, votre compte sera supprimé.</p>
          <button id="deleteAccountBtn">Supprimer le compte</button>
          
          <div id="confirmationPopup" class="popup">
          <div class="popup-content text-dark">
              <p>Es-tu sûr de vouloir supprimer ton compte ?</p>
              <div class="popup-buttons">
              <a href="deleteAccuntDone.php" id="confirmDeleteBtn">Oui</a>
              <button id="cancelDeleteBtn">Annuler</button>
              </div>
          </div>
      </section>
    </section>
</div>
<script>
const deleteAccountBtn = document.getElementById('deleteAccountBtn');
const confirmationPopup = document.getElementById('confirmationPopup');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

deleteAccountBtn.addEventListener('click', () => {
  confirmationPopup.style.display = 'block';
});

confirmDeleteBtn.addEventListener('click', () => {
  // Faire ici l'action de suppression du compte
  console.log('Compte supprimé');
  confirmationPopup.style.display = 'none';
});

cancelDeleteBtn.addEventListener('click', () => {
  confirmationPopup.style.display = 'none';
});

</script>
<?php include "../../template/footer.php"; ?>
