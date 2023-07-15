<!-- Notre code pour la découpe et l'affiche du captcha -->
<link href="captcha.css" rel="stylesheet">

<?php
require "../../template/header.php";
session_start();
require "../conf.inc.php";
require "../functions.php";

$_SESSION["email_try"] = $_POST["email"];
$_SESSION["pwd_try"] = $_POST["pwdUser"];
$_SESSION["id_session"] = uniqid(); 

$directory = 'uploads/*.{jpg,jpeg,gif,png}';
$imgTable = glob($directory, GLOB_BRACE);

shuffle($imgTable);

// Vérifier si le tableau des indices utilisés existe en session
if (empty($_SESSION['usedImageIndices'])) {
    $_SESSION['usedImageIndices'] = array(); // créer un tableau vide 
}

$usedIndices = $_SESSION['usedImageIndices'];

// Vérifier si tous les indices ont été utilisés
if (count($usedIndices) === count($imgTable)) {
    // Tous les indices ont été utilisés, réinitialiser le tableau
    $usedIndices = array();
}

// Parcourir les images dans un ordre aléatoire
foreach ($imgTable as $index => $image) {
    // Vérifier si l'indice a déjà été utilisé
    if (!in_array($index, $usedIndices)) {
        // Stocker l'image grâce à son indice
        $randomImage = $image;

        // Ajouter l'indice utilisé au tableau des indices utilisés
        $usedIndices[] = $index;

        // Mettre à jour le tableau des indices utilisés en session
        $_SESSION['usedImageIndices'] = $usedIndices;

        break; // Sortir de la boucle après avoir trouvé une image non utilisée
    }
}

// pathinfo récupére l'extension du fichier 
$extension = strtolower(pathinfo($randomImage, PATHINFO_EXTENSION));

// initialise l'image pour la lire et la charger = manipuler 
if ($extension === 'jpg' || $extension === 'jpeg') {
    $imageStock = imagecreatefromjpeg($randomImage);
} elseif ($extension === 'png') {
    $imageStock = imagecreatefrompng($randomImage);
} elseif ($imageOriginale === false) {
    echo "Erreur lors du chargement de l'image d'origine.";
    exit();
} else {
    // Extension d'image non prise en charge
    echo 'Extension d\'image non prise en charge.';
    exit();
}

// On fait les mesures de l'image pour bien la découper
$largeurOriginale = imagesx($imageStock);
$hauteurOriginale = imagesy($imageStock);

// Définir la taille souhaitée pour l'image redimensionnée
$nouvelleLargeur = 400;
$nouvelleHauteur = 400;

// Calculer les nouvelles dimensions en conservant le rapport hauteur/largeur
if ($largeurOriginale > $hauteurOriginale) {
    $nouvelleHauteur = ($hauteurOriginale / $largeurOriginale) * $nouvelleLargeur;
} else {
    $nouvelleLargeur = ($largeurOriginale / $hauteurOriginale) * $nouvelleHauteur;
}

// Créer une nouvelle image redimensionnée avec les nouvelles dimensions
$imageRedimensionnee = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur);
imagecopyresampled($imageRedimensionnee, $imageStock, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $largeurOriginale, $hauteurOriginale);

// On fait les mesures de l'image pour bien la découper
$largeurRedimensionee = imagesx($imageRedimensionnee);
$hauteurRedimensionee = imagesy($imageRedimensionnee);

// On prend les dimensions 3x3 pour nous donner 9 images découpés
$cuttingLargeur = $largeurRedimensionee / 3;
$cuttingHauteur = $hauteurRedimensionee / 3;

if ($cuttingLargeur <= 0 || $cuttingHauteur <= 0) {
    // Les dimensions de découpe sont invalides
    echo 'Les dimensions de découpe sont invalides.';
    exit();
}

// Ouvre la ressource finfo qui va vérifier qu'on découpe bien une image
$imageInfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($imageInfo, $randomImage);

$tableauImageDecouper = [];

if ($mimeType !== false && strpos($mimeType, 'image/') === 0) {
    for ($colonne = 0; $colonne < 3; ++$colonne) {
        for ($ligne = 0; $ligne < 3; ++$ligne) {

            $x = $ligne * $cuttingLargeur;
            $y = $colonne * $cuttingHauteur;

            $imagecut = imagecrop($imageRedimensionnee, [
                "x" => $x,
                "y" => $y,
                'width' => $cuttingLargeur,
                'height' => $cuttingHauteur
            ]);

            // Redimensionner l'image découpée à une taille fixe
            $miniImage = imagescale($imagecut, $cuttingLargeur, $cuttingHauteur);

            // Stocker l'image redimensionnée dans le tableau
            $tableauImageDecouper[] = $miniImage;
        }
    }
} else {
    echo "Il y a une erreur";
}

// Ferme la ressource finfo
finfo_close($imageInfo);
?>

<div class="captcha-container">
    <div class="captcha-square">
        <?php
        $OldImagesDir = glob("../captchaImg/*.{jpg,gif,png}", GLOB_BRACE);

        foreach ($OldImagesDir as $image) {
            unlink($image);
        }
        
        $code = [];
        foreach ($tableauImageDecouper as $index => $imageDuTableau) {
            $currentCode= generatecode();
            $code[] = $currentCode;
            // $_SERVER['DOCUMENT ROOT'] -> sert à bien spécifier la route absolue 
            $nomImage = '../captchaImg/mini_image_' . $currentCode . '.png'; // Générer un nom unique pour chaque mini-image
            

            // Enregistrer l'image découpée en tant que fichier PNG
            imagepng($imageDuTableau, $nomImage);
        }
        $captchaList = json_decode(file_get_contents('captcha.json'), true);

        $captchaList[$_SESSION['id_session']] = $code;
        // echo "<pre>";
        // print_r($captchaList);
        // echo "</pre>";
        // die;
        file_put_contents('captcha.json', json_encode($captchaList));


        
        

        $imagesDir = glob("../captchaImg/" . "*.{jpg,gif,png}", GLOB_BRACE);
    
        shuffle($imagesDir);
        foreach ($imagesDir as $image) {
            // Afficher la mini-image avec son URL
            echo '<img class="captcha-image" draggable="true" src="' . $image . '" width="' . $cuttingLargeur . 'px" height="' . $cuttingHauteur . 'px" alt="Mini Image">';
        };
        ?>
    </div>
    <div class="buttonCaptcha">
        <div class="imageFini">
            <img src="<?php echo $randomImage; ?>" class="puzzle-image" width="200px" alt="texte alternatif">
        </div>
        <button value="Rafraichir" id="refresh" type="button">Actualiser</button>
        <button class="favorite" type="button">Valider</button>
    </div>
</div>


<!-- javascript pour le captcha -->
<script>
    document.querySelector('.favorite').addEventListener('click', function() {
    let selectedImages = [];

    // Récupérer les images sélectionnées
    let images = document.querySelectorAll('.captcha-image');

    images.forEach(function(image) {
        let hexCode = image.getAttribute('src').split('_')[2].split('.')[0];
        selectedImages.push(hexCode);

    });

    // Envoyer les images sélectionnées au serveur en utilisant Fetch
    fetch('captchaTraitement.php', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({images : selectedImages})
    }) 
    .then(function(response) {
        // console.log(response);
        if (response.ok) {
            // console.log(response.json());
            return response.json();
           
        } else {
            throw new Error('Erreur lors de la requête AJAX. Statut : ' + response.status);
        }
    })
    .then(function(data) {
        console.log(data);
        // Traitez la réponse du serveur ici si nécessaire

        if(data === true) {

          window.location.href='../verif_before_login/loginVerify.php'// + email + '&pwdUser=' + pwd;
        }else {
            alert('Le captcha n\'est pas correcte');
        }
    })
    .catch(function(error) {
        // Gérez les erreurs éventuelles
        console.error(error);
    });

    
});
</script>

<script type="text/javascript" src="captcha.js"></script>
