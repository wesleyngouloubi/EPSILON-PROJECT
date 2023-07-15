// Récupère toutes les images avec la classe "captcha-image"
const images = document.querySelectorAll(".captcha-image");

let draggedImage = null;

// Ajoute un écouteur d'événement pour le début du glisser-déposer
images.forEach((image) => {
  image.addEventListener("dragstart", (e) => {
    draggedImage = e.target;
  });
});

// Ajoute un écouteur d'événement pour le relâchement de l'image glissée
document.addEventListener("dragover", (e) => {
  e.preventDefault();
});

// Ajoute un écouteur d'événement pour le lâcher de l'image glissée
document.addEventListener("drop", (e) => {
  e.preventDefault();

  // Vérifie si l'élément sur lequel l'image a été déposée est une image
  if (e.target.tagName === "IMG") {
    const droppedImage = e.target;

    // Récupère l'URL de l'image glissée
    const draggedImageUrl = draggedImage.getAttribute("src");

    // Récupère l'URL de l'image déposée
    const droppedImageUrl = droppedImage.getAttribute("src");

    // Échange les URLs des images
    draggedImage.setAttribute("src", droppedImageUrl);
    droppedImage.setAttribute("src", draggedImageUrl);
  }

  draggedImage = null;
});

let refresh = document.getElementById("refresh");

refresh.addEventListener("click", () => {
  location.reload(), false;
});

