document.addEventListener('DOMContentLoaded', () => {
  const content = document.getElementsByTagName('body')[0];
  const contentNav = document.getElementsByTagName('nav')[0];
  const contentNavText = document.getElementsByTagName('a')[0];
  const darkMode = document.getElementById('btn-darkMode');

  // Vérifie si le mode sombre est déjà activé
  const isDarkMode = localStorage.getItem('darkMode') === 'true';

  // Applique le mode sombre si nécessaire
  if (isDarkMode) {
    darkMode.classList.add('active');
    content.classList.add('night');
    contentNav.classList.toggle('bg-dark');
    contentNavText.classList.toggle('text-white');
  }

  darkMode.addEventListener('click', () => {
    darkMode.classList.toggle('active');
    content.classList.toggle('night');
    contentNav.classList.toggle('bg-dark');
    contentNavText.classList.toggle('text-white');

    // Enregistre l'état du mode sombre dans le stockage local
    const isDarkModeActive = darkMode.classList.contains('active');
    localStorage.setItem('darkMode', isDarkModeActive);
  });
});
