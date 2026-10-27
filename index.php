<?php

include_once('utils/utils.php');

$pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$request = $pdo->prepare('SELECT j.titre, j.joueurs_min , j.joueurs_max , j.duree , m.prenom ,c.nom_categorie FROM jeu j 
                INNER JOIN categorie c ON c.id_categorie = j.id_categorie
                INNER JOIN membre m ON m.id_membre = j.id_membre
                ORDER BY j.titre');
                $request->execute();
                $jeux = $request->fetchAll();
                
include('includes/header.php');
?>

<h1>Liste des jeux</h1>

<?php foreach ($jeux as $jeu): ?>
    <div>
        <h2><?= $jeu['titre'] ?> (<?= $jeu['nom_categorie'] ?>)</h2>
        
        <p>Joueurs : <?= formatJoueurs($jeu['joueurs_min'], $jeu['joueurs_max']) ?></p>
        <p>Durée : <?= $jeu['duree'] ?> min (<?= categorieDuree($jeu['duree']) ?>)</p>
        <p>Ajouté par : <?= $jeu['prenom'] ?></p>
    </div>
<?php endforeach; ?>

<?php
include('includes/footer.php');
?>
