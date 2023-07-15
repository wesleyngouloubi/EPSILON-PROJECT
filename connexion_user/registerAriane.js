// Récupération des éléments du fil d'Ariane
let breadcrumbSteps = document.getElementsByClassName("step");
let formSteps = document.getElementsByClassName("form-step");
let currentStep = 1; // L'étape actuelle est initialement définie sur 1

// Gestion du clic sur le bouton "Précédent" pour revenir à l'étape précédente
let prevButton = document.getElementById("btn-previous");

// Sélection de tous les boutons avec la classe "btn-register"
let btnRegisters = document.querySelectorAll(".btn-register");



// Affichage de l'étape spécifiée
function showStep(stepNumber) {
  // Masquer toutes les étapes
  for (let i = 0; i < formSteps.length; i++) {
    formSteps[i].style.display = "none";
  }

  // Afficher l'étape spécifiée
  if (formSteps[stepNumber - 1]) {
    formSteps[stepNumber - 1].style.display = "block";
  }

  // Mettre à jour l'étape actuelle dans les paramètres d'URL
  updateURLParams("step", stepNumber);

  // Mettre à jour la classe active dans le fil d'Ariane
  for (let i = 0; i < breadcrumbSteps.length; i++) {
    breadcrumbSteps[i].classList.remove("active");
    if (i < stepNumber) {
      breadcrumbSteps[i].classList.add("active");
    }
  }
}

// Gestion du clic sur une étape du fil d'Ariane
for (let i = 0; i < breadcrumbSteps.length; i++) {
  breadcrumbSteps[i].addEventListener("click", (e) => {
    e.preventDefault();
    let stepNumber = parseInt(e.currentTarget.getAttribute("data-step"));
    showStep(stepNumber);
  });
}

// Affichage de l'étape actuelle
checkStoredStep();


// Validation du formulaire de l'étape spécifiée
function validateForm(stepNumber) {
  // Récupérer les champs de saisie de l'étape actuelle
  let inputs = formSteps[stepNumber - 1].querySelectorAll("input, select, textarea");

  // Vérifier la validité de chaque champ de saisie
  let isValid = true;
  inputs.forEach((input) => {
    if (!input.checkValidity()) {
      isValid = false;
      input.reportValidity();
    }
  });

  if (isValid) {
    // Passage à l'étape suivante
    showStep(stepNumber + 1);
  } else {
    // Afficher un message d'erreur ou traiter les erreurs spécifiques
    console.error("Erreur de validation du formulaire");
  }
}

// Parcourir tous les boutons et ajouter le gestionnaire d'événement
btnRegisters.forEach((btnRegister) => {
  btnRegister.addEventListener("click", (e) => {
    e.preventDefault();

    // Récupération de l'étape actuelle
    let currentStep = getCurrentStep();

    // Validation du formulaire de l'étape actuelle
    validateForm(currentStep);
  });
});

if (prevButton) {
  prevButton.addEventListener("click", (e) => {
    e.preventDefault();
    let currentStep = getCurrentStep();
    if (currentStep > 1) {
      showStep(currentStep - 1);
    }
  });
}

// Récupération de l'étape actuelle à partir des paramètres d'URL
function getCurrentStep() {
  const urlParams = new URLSearchParams(window.location.search);
  const storedStep = parseInt(urlParams.get("step"));
  return storedStep ? storedStep : 1;
}

// Mise à jour des paramètres d'URL
function updateURLParams(key, value) {
  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set(key, value);
  const newURL = window.location.pathname + "?" + urlParams.toString();
  window.history.replaceState({}, "", newURL);
}

// Vérification des paramètres d'URL pour afficher l'étape stockée
function checkStoredStep() {
  const urlParams = new URLSearchParams(window.location.search);
  const storedStep = parseInt(urlParams.get("step"));

  if (storedStep) {
    showStep(storedStep);
  }
}

// Réinitialiser les paramètres d'URL à la première étape lors de la fermeture de la page
window.addEventListener("beforeunload", () => {
  updateURLParams("step", 1);
});

// Affichage de l'étape actuelle
showStep(currentStep);



