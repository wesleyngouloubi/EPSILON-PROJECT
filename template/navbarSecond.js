// Utilisation de JavaScript pur
const accountMenus = document.getElementsByClassName('account-menu');
const accountMenuItems = document.getElementsByClassName('account-menu-items')[0];

Array.from(accountMenus).forEach(accountMenu => {
  accountMenu.addEventListener('mouseover', () => {
    accountMenuItems.style.display = 'block';
  });

  accountMenu.addEventListener('mouseout', () => {
    accountMenuItems.style.display = 'none';
  });
});


// let NewPageNavbar = document.getElementById("NewPageLogin");
// let NewPageNavbar2 = document.getElementById("NewPageRegister");


// NewPageNavbar.addEventListener("click", () => {
//     let newLoginURL = "/connexion_user/login.php"; 
//     openPage(newLoginURL);
// })

// NewPageNavbar2.addEventListener("click", () => {
//     let newLoginURL = "/connexion_user/registerAriane.php"; 
//     openPage(newLoginURL);
// })


// let openedPages = {}; // Stocker les pages déjà ouvertes

// function openPage(url) {
//     if (openedPages[url] && !openedPages[url].closed) {
//         // La page est déjà ouverte, déplacer le focus vers cette fenêtre
//         openedPages[url].focus();
//     } else {
//         // Ouvrir une nouvelle fenêtre ou un nouvel onglet
//         let win = window.open(url, '_blank');
//         if (win) {
//         // Stocker la référence à la fenêtre ouverte
//         openedPages[url] = win;
//         }
//     }
// }



           