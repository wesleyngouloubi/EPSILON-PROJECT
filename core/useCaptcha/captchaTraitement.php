

<?php
session_start();

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    if (is_array($decoded)) {
        $_POST = $decoded;
    } else {
        die("Le format de la requête est invalide.");
    }
}

// Récupérer le contenu du fichier JSON
$jsonContent = file_get_contents('captcha.json');

// Décoder le contenu JSON en tant que tableau
$response = json_decode($jsonContent, true);

// Récupérer le tableau des images sélectionnées
$selectedImages = $_POST['images'];

// echo "<pre>";
// print_r($response[$_SESSION["id_user"]]);
// print_r(array_values($selectedImages));
// echo "</pre>";
// die;
$selectedImagesArray = array_values($selectedImages);
$responseArray = array_values($response[$_SESSION["id_session"]]);

unset($response[$_SESSION["id_session"]]);
file_put_contents('captcha.json', json_encode($response));

if ((count($selectedImagesArray) === count($responseArray)) && (empty(array_diff_assoc($selectedImagesArray, $responseArray)))) {
    // Les images sélectionnées correspondent à l'ordre du tableau dans la réponse 
    echo json_encode(true);

} else {
    // Les images sélectionnées ne correspondent pas à l'ordre du tableau dans la réponse JSON
    echo json_encode(false);
}
?>
