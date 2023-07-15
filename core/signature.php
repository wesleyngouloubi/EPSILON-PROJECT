<div id="dessin">
    <h2>Veux-tu t'entrainer à dessiner, tu peux ici : </h2>
    <canvas id="canvas" width="400" height="400"></canvas>
    <div class="button-container">
        <button id="clear-button">Effacer</button>
        <div class="color-picker">
            <label for="color-input">Couleur :</label>
            <input type="color" id="color-input" value="#000000">
        </div>
    </div>
</div>



<style>
#dessin {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    text-align: center;
}

h1 {
    color: #333;
}

#canvas {
    background-color: yellow;
    border: 2px solid #333;
    margin-top: 20px;
}

.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

#clear-button {
    background-color: #ebbb1b;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}

#clear-button:hover {
    background-color: #555;
}

.color-picker {
    display: flex;
    align-items: center;
    margin-left: 20px;
}

.color-picker label {
    margin-right: 10px;
    font-weight: bold;
    color: #ebbb1b;
}

.color-picker input[type="color"] {
    appearance: none;
    -webkit-appearance: none;
    border: none;
    width: 30px;
    height: 30px;
    padding: 0;
    cursor: pointer;
}

.color-picker input[type="color"]::-webkit-color-swatch-wrapper {
    padding: 0;
}

.color-picker input[type="color"]::-webkit-color-swatch {
    border: none;
    border-radius: 50%;
    padding: 0;
}


</style>

<script>
  // Récupérer le contexte du canvas
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

// Définir les dimensions et la position du carré
var squareSize = 200;
var squareX = (canvas.width - squareSize) / 2;
var squareY = (canvas.height - squareSize) / 2;

// Variables pour stocker les coordonnées du pointeur
var isDrawing = false;
var lastX = 0;
var lastY = 0;
var currentColor = '#000000'; // Couleur actuelle du dessin

// Fonction pour dessiner dans le carré
function draw(e) {
  if (!isDrawing) return;
  context.lineWidth = 5;
  context.lineCap = 'round';
  context.strokeStyle = currentColor;

  // Dessiner une ligne entre les coordonnées précédentes et actuelles
  context.beginPath();
  context.moveTo(lastX, lastY);
  context.lineTo(getX(e), getY(e));
  context.stroke();

  // Mettre à jour les coordonnées précédentes avec les coordonnées actuelles
  lastX = getX(e);
  lastY = getY(e);
}

// Fonction pour obtenir les coordonnées X du pointeur (prise en charge souris et toucher)
function getX(e) {
  if (e.touches) {
    return e.touches[0].clientX - canvas.getBoundingClientRect().left;
  } else {
    return e.clientX - canvas.getBoundingClientRect().left;
  }
}

// Fonction pour obtenir les coordonnées Y du pointeur (prise en charge souris et toucher)
function getY(e) {
  if (e.touches) {
    return e.touches[0].clientY - canvas.getBoundingClientRect().top;
  } else {
    return e.clientY - canvas.getBoundingClientRect().top;
  }
}

// Événements de suivi du toucher et de la souris
canvas.addEventListener('touchstart', function (e) {
  isDrawing = true;
  lastX = getX(e);
  lastY = getY(e);
});

canvas.addEventListener('touchmove', draw);
canvas.addEventListener('touchend', function () {
  isDrawing = false;
});

canvas.addEventListener('mousedown', function (e) {
  isDrawing = true;
  lastX = getX(e);
  lastY = getY(e);
});

canvas.addEventListener('mousemove', draw);
canvas.addEventListener('mouseup', function () {
  isDrawing = false;
});

// Gérer l'événement de clic sur le bouton "Effacer"
var clearButton = document.getElementById('clear-button');
clearButton.addEventListener('click', function () {
  context.clearRect(0, 0, canvas.width, canvas.height);
});

// Gérer l'événement de changement de couleur
var colorInput = document.getElementById('color-input');
colorInput.addEventListener('change', function () {
  currentColor = colorInput.value;
});

</script>
