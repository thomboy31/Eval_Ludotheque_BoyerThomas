<?php

session_start();
if (!isset($_SESSION['id_membre'])) {
    header('Location: connexion.php');
    exit;
}

include_once('utils/utils.php');

try {
$pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$request = $pdo->prepare('SELECT j.titre , j.joueurs_min , j.joueurs_max , j.duree , c.nom_categorie , c.id_categorie FROM jeu j
INNER JOIN categorie c ON c.id_categorie = j.id_categorie
ORDER BY nom_categorie ');
$request->execute();
$categories = $request->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {

    if (!empty($_POST['titre']) &&
        !empty($_POST['joueurs_min']) && $_POST['joueurs_min'] !== '' &&
        !empty($_POST['joueurs_max']) && $_POST['joueurs_max'] !== '' &&
        !empty($_POST['duree']) && $_POST['duree'] !== '' &&
        !empty($_POST['id_categorie'])
    ) {

        $titre = trim($_POST['titre']);
        $joueurs_min = $_POST['joueurs_min'];
        $joueurs_max = $_POST['joueurs_max'];
        $duree = $_POST['duree'];
        $id_categorie = $_POST['id_categorie'];

        if (filter_var($joueurs_min, FILTER_VALIDATE_INT) !== false &&
            filter_var($joueurs_max, FILTER_VALIDATE_INT) !== false &&
            filter_var($duree, FILTER_VALIDATE_INT) !== false &&
            filter_var($id_categorie, FILTER_VALIDATE_INT) !== false
        ) {

            if ((int)$joueurs_min >= 1 &&
                $joueurs_max >= $joueurs_min && $duree > 0
            ) {

                $request = $pdo->prepare('SELECT titre FROM jeu WHERE titre = ?');
                $request->bindParam(1, $titre, PDO::PARAM_STR);
                $request->execute();
                $data = $request->fetch(PDO::FETCH_ASSOC);

                if (empty($data)) {

                    $request = $pdo->prepare('INSERT INTO jeu(titre, joueurs_min, joueurs_max, duree, id_categorie, id_membre) VALUES (?, ?, ?, ?, ?, ?)');

                    $request->bindParam(1, $titre, PDO::PARAM_STR);
                    $request->bindParam(2, $joueurs_min, PDO::PARAM_INT);
                    $request->bindParam(3, $joueurs_max, PDO::PARAM_INT);
                    $request->bindParam(4, $duree, PDO::PARAM_INT);
                    $request->bindParam(5, $id_categorie, PDO::PARAM_INT);
                    $request->bindParam(6, $_SESSION['id_membre'], PDO::PARAM_INT);

                    $request->execute();

                    $message = "Le jeu a bien été ajouté avec succès.";

                } else {
                    $message = "Ce jeu existe déjà dans le catalogue.";
                }

            } else {
                $message = "Vérifiez le nombre minimum et maximum de joueurs ainsi que la durée.";
            }

        } else {
            $message = "Les joueurs, la durée et la catégorie doivent être des nombres entiers.";
        }

    } else {
        $message = "Veuillez remplir tous les champs du formulaire.";
    }
}

} catch (Exception $error) {
    die($error->getMessage());
}

include('includes/header.php');
?>

<main>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <label for="titre">Titre<input type="text" name="titre" id="titre">
        <label for="joueurs_min">Nombre minimum de joueurs<input type="number" name="joueurs_min" id="joueurs_min">
        <label for="joueurs_max">Nombre maximum de joueurs<input type="number" name="joueurs_max" id="joueurs_max">
        <label for="duree">Durée (en minutes)<input type="number" name="duree" id="duree">
        <label for="id_categorie">Catégorie<select name="id_categorie" id="id_categorie">
        <option value="">Choisir une catégorie</option>

    <?php foreach ($categories as $categorie): ?>
        <option value="<?php echo $categorie['id_categorie']; ?>">
        <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
        </option>
    <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="Ajouter le jeu">
    </form>
</main>

<?php
include('includes/footer.php');
?>