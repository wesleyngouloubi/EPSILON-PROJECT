<?php 
    session_start();
    require "../../core/conf.inc.php";
    require "../../core/functions.php";
    include "../../template/header.php";
    include "../../template/navbar.php";

    redirectIfNotConnected();
    
	

    $directoryHairs = 'image_avatar/hairs/*.{png}';
    $imgHairs = glob($directoryHairs, GLOB_BRACE);

    $directoryMouths = 'image_avatar/mouths/*.{png}';
    $imgMouths = glob($directoryMouths, GLOB_BRACE);

    $directoryFaces = 'image_avatar/faces/*.{png}';
    $imgFaces = glob($directoryFaces, GLOB_BRACE);

    $directoryEyes = 'image_avatar/eyes/*.{png}';
    $imgEyes = glob($directoryEyes, GLOB_BRACE);

    $directoryNoses = 'image_avatar/noses/*.{png}';
    $imgNoses = glob($directoryNoses, GLOB_BRACE);


    // var_dump($imgFaces);
    // $bodies = glob("/image_avatar/bodies/*.png");


?>

<link href="avatarModify.css" rel="stylesheet">

<h1>Modifier mon avatar</h1>

<div class="avatar-container">
    <div class="avatar-face">
        <canvas id="finalCanvas" width="200" height="200"></canvas>
    </div>


        
    <div class="avatar-controls">
        <button class="control-button" id="change-hair">Les cheveux</button>
        <button class="control-button" id="change-mouth">La bouche</button>
        <button class="control-button" id="change-face">Le visage</button>
        <button class="control-button" id="change-eye">Les yeux</button>
        <button class="control-button" id="change-nose">Le nez</button>
    </div>

    <!-- Cards for Hairs -->
    <div class="row hairs">
        <?php foreach ($imgHairs as $item) : ?>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3" style="height: 10px; width: 150px;">
                <div class="card" data-imgsrc="<?php echo $item ?>">
                    <img src="<?= $item ?>" alt="Hair">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Cards for Mouth -->
    <div class="row mouths">
        <?php foreach ($imgMouths as $item) : ?>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3" style="height: 10px; width: 150px;">
                <div class="card" data-imgsrc="<?php echo $item ?>">
                    <img src="<?= $item ?>" alt="Mouth">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Cards for faces -->
    <div class="row faces">
        <?php foreach ($imgFaces as $item) : ?>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3" style="height: 10px; width: 150px;">
                <div class="card" data-imgsrc="<?php echo $item ?>">
                    <img src="<?= $item ?>" alt="face">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Cards for eyes -->
    <div class="row eyes">
        <?php foreach ($imgEyes as $item) : ?>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3" style="height: 10px; width: 150px;">
                <div class="card" data-imgsrc="<?php echo $item ?>">
                    <img src="<?= $item ?>" alt="eyes">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Cards for noses -->
    <div class="row noses">
        <?php foreach ($imgNoses as $item) : ?>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3" style="height: 10px; width: 150px;">
                <div class="card" data-imgsrc="<?php echo $item ?>">
                    <img src="<?= $item ?>" alt="noses">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="save-button-container" id="sendAvatar">
    <button class="save-button">Enregistrer</button>
    </div>

</div>

<script type="text/javascript" src="avatarModify.js"></script>
<?php include "../../template/footer.php" ?>
