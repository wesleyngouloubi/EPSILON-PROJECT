<?php
    session_start();
    require "../template/header.php";
	require "../core/conf.inc.php";
    require "../core/functions.php";
    include "../template/navbarBack.php";

    if(!isAdmin()){
		header("location:../index.php");
	}

    
?>
<link href="captcha.css" rel="stylesheet">
<br>

<form action="uploadCaptcha.php" method="POST" enctype="multipart/form-data">
  Ajouter une nouvelle image :
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Enregistrer" name="submit">
</form>

<section id="library">
    <?php
        $directory = '../core/useCaptcha/uploads/*.{jpg,jpeg,gif,png}';
        $files = glob($directory,GLOB_BRACE);
        
        echo '<h2>La Librairie Image du captcha :</h2> <br>';
        foreach($files as $image)
        { 
            $rename = basename($image);
            echo '<div>';
            echo '<img class="img-thumbnail" id="imageLibrary" width="200px" src="'.$image.'" alt="'.$rename.'">';
            echo '<a class="btn btn-warning mx-4" href="uploadCaptcha.php?image='.$image.'">Supprimer</a>';
            echo '</div>';
            echo '<br>';
        }
    ?>
</section>



