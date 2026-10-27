<?php 
session_start(); 
include_once('utils/utils.php'); 

$nav = '<a href="./index.php">Accueil</a>'; 

if (isset($_SESSION['id'])) { 
    $nav .= ' <span>' . htmlspecialchars($_SESSION['prenom']) . '</span>'; 
    $nav .= ' <a href="deconnexion.php">Se Déconnecter</a>'; 
    $nav .= ' <a href="ajout-jeu.php">Ajouter un Jeu</a>'; 
} else { 
    $nav .= ' <a href="./inscription.php">Inscription</a>'; 
    $nav .= ' <a href="./connexion.php">Connexion</a>'; 
} 
?> 
<!DOCTYPE html> 
<html lang="en">
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Le Dé Fêlé</title> 
    <link href="./src/css/style.css" rel="stylesheet"> 
</head> 
<body> 
<header> 
    <nav> 
        <?php echo $nav; ?> 
    </nav> 
</header>

