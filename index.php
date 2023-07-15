<!-- Page d'accueil du site -->
<?php
    require "template/header.php";
	session_start();
	require "core/conf.inc.php";
 	require "core/functions.php";
    require "template/navbar.php";
    
?>

<section>
    <div id="image-background">
        <h1 id="titleOne">EPSILON</h1>
        <div id="paragraph">
            <p>Football à 5vs5<br> Réserver votre terrain</p><br>
        </div>
        <div id="btn-bg">
            <a href="/src/stadium.php" class="btn btn-warning"><b>Maintenant</b></a>
        </div>
    </div>
</section>

<section>
    <div class="paragraphTwo">
        <img class="img-fluid" src="image/image-v4.jpg" alt="...">
        <p>
            Le monde du <b>football</b> est en ébullition alors que la saison bat son plein. Dans un match électrisant qui s'est déroulé hier soir, 
            deux équipes rivales se sont affrontées avec une intensité incroyable. Les fans étaient en liesse tandis que les joueurs se donnaient 
            à fond sur le terrain, offrant un <b>spectacle captivant</b> du début à la fin.<br><br> L'équipe locale a réussi à prendre l'avantage grâce à un superbe 
            but marqué en seconde période, déclenchant <i>explosion de joie</i> dans le stade. Cependant, l'équipe visiteuse n'a pas tardé à répliquer avec 
            une contre-attaque fulgurante qui a abouti à l'égalisation.<br><br> Les deux formations se sont livré <b>bataille acharnée</b> 
            jusqu'au coup de sifflet final, laissant les spectateurs en admiration devant leur talent et leur détermination. 
            Ce match restera gravé dans les mémoires comme une démonstration de <b>l'esprit compétitif</b> et de la passion qui anime le monde du football
        </p>
    </div>
</section>

<!-- Image Zoom Foot -->
<section class="page-section" id="luffyEtSesNakamas">
    <div class="container">
        <div class="slogan">
            <h2 class="section-heading text-italic"><u>Le Football est plus qu'une passion, c'est un mode de vie...<br>Mr. Zehma Fares</u></h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-4">
                <!-- Première photo -->
                <div class="portfolio-item">
                        <div class="zoom">
                            <div class="image">
                            <img class="img-fluid" src="image/image-n.gif" alt="...">
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">FIFA</div>
                        <div class="portfolio-caption-subheading text-muted">Match de préparation</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4">
                <!-- 2ème photo -->
                <div class="portfolio-item">
                        <div class="zoom">
                            <div class="image">
                            <img class="img-fluid" src="image/image6-spe.gif" alt="...">
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">Blue Lock</div>
                        <div class="portfolio-caption-subheading text-muted">Anime sur le Foot</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4">
                <!-- 3ème photo -->
                <div class="portfolio-item">
                        <div class="">
                            <div class="image">
                            <img class="img-fluid" src="image/image-v.webp" alt="..." />
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">Coupe Epsilon</div>
                        <div class="portfolio-caption-subheading text-muted">Bientot disponible</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                <!-- 4ème photo -->
                <div class="portfolio-item">
                        <div class="zoom">
                            <div class="image">
                            <img class="img-fluid" src="image/image-v1.webp" alt="..." />
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">YEAAAAA YEEEEEAH</div>
                        <div class="portfolio-caption-subheading text-muted">You very Grinch Bro</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4 mb-sm-0">
                <!-- 5ème photo -->
                <div class="portfolio-item">
                        <div class="zoom">
                            <div class="image">
                            <img class="img-fluid" src="image/image-v3.webp" alt="..." />
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">Echec et Foot</div>
                        <div class="portfolio-caption-subheading text-muted">J'ai pas trop capté le délire en vrai</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <!-- 6ème photo -->
                <div class="portfolio-item">
                        <div class="">
                            <div class="image">
                            <img class="img-fluid" src="image/image5-spe.gif" alt="..." />
                            </div>
                        </div>
                    <div>
                        <div class="portfolio-caption-heading">Tornade de feu</div>
                        <div class="portfolio-caption-subheading text-muted">En mode Axel Blaze, tu connais ?</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "template/footer.php" ?>
<!-- Redirection vers le JS (multi-page) -->


