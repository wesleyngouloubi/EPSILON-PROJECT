<?php
session_start();
include "../core/conf.inc.php";
require "../core/functions.php";
include "../template/header.php";


redirectIfAlreadyConnected();
?>

<link href="registerAriane.css" rel="stylesheet">

<nav aria-label="Breadcrumb" class="breadcrumb">
    <ul>

        <!-- <li class="step"><a href="../index.php">Accueil</a></li> -->
        <li class="step active" data-step="1"><a href="#">Mes données personnelles</a></li>
        <li class="step" data-step="2"><a href="#">Me contacter</a></li>
        <li class="step" data-step="3"><a href="#">Mot de passe</a></li>
        <!-- <li class="step" data-step="4"><a href="registerVerifyUser.php">Vérification</a></li> -->
    </ul>
</nav>

<div class="justify-content-center" id="bg-register">
    <div class="col-md-8" id="bg-form">
        <div class="row">
            <div class="col-12">
                <div class="m-6" id="text-bg" class="text-opacity">
                    <h3><img src="/image/miniLogo.png" alt="Logo" width="30px"> Rejoignez Epsilon </h3>
                </div>

                <?php
                if (!empty($_SESSION['errors'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        foreach ($_SESSION['errors'] as $error) {
                            echo "<li>" . $error . "</li>";
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                    unset($_SESSION['errors']);
                }
                ?>

                <div id="registerEpsilon">
                    <form action="../core/verif_before_login/checkRegisterAriane.php" method="POST">
                        <div id="step1-perso">
                            <div class="form-step">
                                <h4>&nbsp &nbsp Informations personnelles</h4>

                                <div class="for-input">
                                    <div class="text-opacity">Genre : &nbsp</div>

                                    <label for="gender0" class="form-label">M.</label>
                                    <input class="form-check-input" type="radio" id="gender0" name="gender"
                                        checked="checked" value='m' required>

                                    <label for="gender1" class="form-label">Mme.</label>
                                    <input class="form-check-input" type="radio" id="gender1" name="gender" value='f'>

                                    <label for="gender2" class="form-label">Autre</label>
                                    <input class="form-check-input" id="gender2" type="radio" name="gender" value='o'>
                                </div>

                                <div class="for-input">
                                    <div class="col-md-8">
                                        <label>
                                            <div class="text-opacity">Nom de famille :</div>
                                        </label>
                                        <input class="form-control" type="text" name="lastname" id="lastname"
                                            placeholder="Votre nom" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : ""; ?>" required>
                                    </div>

                                    <div class="col-md-8">
                                        <label>
                                            <div class="text-opacity">Prénom :</div>
                                        </label>
                                        <input class="form-control" type="text" name="firstname" id="firstname"
                                            placeholder="Votre prénom" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : ""; ?>" required>
                                    </div>
                                </div>

                                <div class="for-input">
                                    <div class="col-md-6">
                                        <label for="birthday" class="form-label">
                                            <div class="text-opacity">Votre date de naissance :</div>
                                        </label>
                                        <input class="form-control" type="date" id="birthday" name="birthday"
                                            placeholder="Votre date de naissance" min="1900-01-01" max="" required>
                                    </div>
                                </div>

                                <div>
                                    <button class="btn btn-primary mb-4 btn-register">Suivant</button>
                                </div>

                            </div>
                        </div>

                        <div id="step2-contact">
                            <div class="form-step">

                                <div class="for-input">
                                    <div class="col-md-8">
                                        <div class="dimension-input">
                                            <label>
                                                <div class="text-opacity">Email :</div>
                                            </label>
                                            <input class="form-control" type="email" name="email" placeholder="Votre email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="dimension-input">

                                            <label>
                                                <div class="text-opacity">Numéro de tél :</div>
                                            </label>
                                            <div class="input-email">
                                                <input class="form-control telephone-input" value="+33" name="phone" required readonly>
                                                <input class="form-control" width="200px" type="tel" id="phone" name="phone"
                                                    placeholder="Votre numéro" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="btn-register">
                                        <button class="btn btn-primary mb-4" type="button">Suivant</button>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div id="step3-connexion">
                            <div class="form-step">

                                <div class="for-input">
                                    <div class="col-md-8">
                                        <div class="dimension-input">
                                            <label>
                                                <div class="text-opacity">Mot de passe : </div>
                                            </label>
                                            <input class="form-control" type="password" name="pwd"
                                                placeholder="Votre mot de passe" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="dimension-input">

                                            <label>
                                                <div class="text-opacity">Confirmation du mot de passe :</div>
                                            </label>
                                            <input class="form-control" type="password" name="pwdConfirm"
                                                placeholder="Confirmation" required autocomplete="off">

                                        </div>
                                    </div>

                                    <input class="form-check-input" type="checkbox" id="cgu" name="cgu" required>
                                    <label class="form-label" for="cgu">
                                        J'accepte les CGUs
                                    </label>
                                </div>

                                <div>
                                    <label id="register">
                                        <button class="btn btn-primary mb-4">S'inscrire</button>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="stepContent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="registerAriane.js"></script>
<script type="text/javascript" src="changeDate.js"></script>
<?php include "../template/footer.php"; ?>