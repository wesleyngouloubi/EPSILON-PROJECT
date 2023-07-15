<?php
    // Pour supprimer les données de l'user dans session
    // et le rediriger à la page d'accueil
    session_start();
    session_destroy();
    header("Location:../index.php");
?>