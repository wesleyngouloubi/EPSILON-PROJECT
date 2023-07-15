const btnHair = document.getElementById('change-hair');
const btnMouth = document.getElementById('change-mouth');
const btnFace = document.getElementById('change-face');

const btnEye = document.getElementById('change-eye');
const btnNose = document.getElementById('change-nose');

const imgHair = document.querySelector('.hairs');
const imgMouth = document.querySelector('.mouths');
const imgFace = document.querySelector('.faces');

const imgEye = document.querySelector('.eyes');
const imgNose = document.querySelector('.noses');

btnHair.addEventListener('click', () => {
    imgHair.style.display = 'flex';
    imgMouth.style.display = 'none';
    imgFace.style.display = 'none';
    imgEye.style.display = 'none';
    imgNose.style.display = 'none';
});

btnMouth.addEventListener('click', () => {
    imgHair.style.display = 'none';
    imgMouth.style.display = 'flex';
    imgFace.style.display = 'none';
    imgEye.style.display = 'none';
    imgNose.style.display = 'none';
});

btnFace.addEventListener('click', () => {
    imgHair.style.display = 'none';
    imgMouth.style.display = 'none';
    imgFace.style.display = 'flex';
    imgEye.style.display = 'none';
    imgNose.style.display = 'none';
});

btnEye.addEventListener('click', () => {
    imgHair.style.display = 'none';
    imgMouth.style.display = 'none';
    imgFace.style.display = 'none';
    imgEye.style.display = 'flex';
    imgNose.style.display = 'none';
});

btnNose.addEventListener('click', () => {
    imgHair.style.display = 'none';
    imgMouth.style.display = 'none';
    imgFace.style.display = 'none';
    imgEye.style.display = 'none';
    imgNose.style.display = 'flex';
});

const imgHair2 = document.querySelectorAll('.hairs .card img');
const imgMouth2 = document.querySelectorAll('.mouths .card img');
const imgFace2 = document.querySelectorAll('.faces .card img');
const imgEye2 = document.querySelectorAll('.eyes .card img');
const imgNose2 = document.querySelectorAll('.noses .card img');

const finalCanvas = document.getElementById('finalCanvas');
const ctx = finalCanvas.getContext('2d');

let hairImage = null;
let mouthImage = null;
let faceImage = null; 
let eyeImage = null;
let noseImage = null;

imgHair2.forEach((img) => {
    img.addEventListener('click', () => {
        hairImage = new Image();
        hairImage.src = img.getAttribute('src');
        hairImage.onload = function() {
            redrawAvatar();
        };
    });
});

imgMouth2.forEach((img) => {
    img.addEventListener('click', () => {
        mouthImage = new Image();
        mouthImage.src = img.getAttribute('src');
        mouthImage.onload = function() {
            redrawAvatar();
        };
    });
});

imgFace2.forEach((img) => {
    img.addEventListener('click', () => {
        faceImage = new Image();
        faceImage.src = img.getAttribute('src');
        faceImage.onload = function() {
            redrawAvatar();
        };
    });
});


imgEye2.forEach((img) => {
    img.addEventListener('click', () => {
        eyeImage = new Image();
        eyeImage.src = img.getAttribute('src');
        eyeImage.onload = function() {
            redrawAvatar();
        };
    });
});

imgNose2.forEach((img) => {
    img.addEventListener('click', () => {
        noseImage = new Image();
        noseImage.src = img.getAttribute('src');
        noseImage.onload = function() {
            redrawAvatar();
        };
    });
});

function redrawAvatar() {
    ctx.clearRect(0, 0, finalCanvas.width, finalCanvas.height);

    if (hairImage) {
        ctx.drawImage(hairImage, 0, 0, finalCanvas.width, finalCanvas.height);
    }

    if (mouthImage) {
        ctx.drawImage(mouthImage, 0, 0, finalCanvas.width, finalCanvas.height);
    }

    if (faceImage) {
        ctx.drawImage(faceImage, 0, 0, finalCanvas.width, finalCanvas.height);
    }
    if (eyeImage) {
        ctx.drawImage(eyeImage, 0, 0, finalCanvas.width, finalCanvas.height);
    }
    if (noseImage) {
        ctx.drawImage(noseImage, 0, 0, finalCanvas.width, finalCanvas.height);
    }
}


const saveBtn = document.getElementById('sendAvatar');
const canvas = document.getElementById('finalCanvas');

saveBtn.addEventListener('click', () => {
  const formData = new FormData();
  formData.append('image', canvas.toDataURL());

  const url = 'saveAvatar.php';

  fetch(url, {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      // Traitement de la réponse du serveur après l'enregistrement de l'image
        if (data) {
            window.location.href = 'settingUser.php';
        }
    })
    .catch((error) => {
      console.error('Erreur lors de l\'enregistrement de l\'image:', error);
    });
});

