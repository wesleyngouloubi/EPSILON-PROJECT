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





