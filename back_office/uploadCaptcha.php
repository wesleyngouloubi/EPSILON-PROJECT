<?php
    $directory = "../core/useCaptcha/uploads/";

if(isset($_GET['image'])) {
    $image = $_GET['image'];
                
    // Vérifier si le fichier existe
    if (file_exists($image)) {
                    // Supprimer le fichier
                    unlink($image);
                    echo 'L\'image a été supprimée avec succès.';
                    header("location: captchaAdmin.php");
    } else {
            var_dump($image);
            echo 'L\'image n\'existe pas.';
    }
}elseif(isset($_FILES["fileToUpload"])){

    $target_file = $directory . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Vérification de l'image ou fausse image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "Votre image a bien été téléchargé - veuillez l'enregistrer dans la librairie";
            $uploadOk = 1;
        } else {
            echo "Ce n'est pas une image.";
            $uploadOk = 0;
        }
    }

    // Vérification si l'image n'existe pas déjà
    if (file_exists($target_file)) {
        echo "Désolé, cette image est déjà enregistré.";
        $uploadOk = 0;
    }

    // Vérification de la taille du fichier
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Désolé, veuillez choisir une image en dessous de 500ko";
        $uploadOk = 0;
    }

    // Autoriser les bons formats images
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Désolé, Voici les formats autorisés : JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    // Vérifier si la variable uploadOk est à O alors = erreur 
    if ($uploadOk == 0) {
        echo "Désolé, le fichier n'a pas été téléchargé.";
    // Sinon on peut commencer à vouloir téléchargé l'image si uploadOk != 0
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Le fichier ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " a bien été téléchargé.";
        } else {
            echo "Désolé mais le fichier n'a pas été téléchargé, veuillez réessayer.";
        }
    }
    
    header("location: captchaAdmin.php");

}header("location: captchaAdmin.php");
?>