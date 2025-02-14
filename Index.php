<?php

include "header.php";

$db = ConnexionBase();

$playlists = $db->query("SELECT * FROM playlist")->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes de l'ensemble des résultats de la requête

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['playlistsubmit'])) {
        $titreAnnonce = $_GET['nomPlaylist'];
        // Préparer et exécuter la requête SQL
        $stmt = $db->prepare("INSERT INTO playlist(name_playlist) VALUES (?)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$nomPlaylist]);
        header("Location: page_playlist.php?name_playlist=$titreAnnonce"); // Je dois adapter mais sans la "pageplaylist.php"
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wazaa Immo</title>
    <link rel="stylesheet" href="Style/style.css"/>
</head>
<body>
    <article>
        <?php foreach($playlists as $playlist): ?> <!-- Entrée dans la boucle pour sortir les annonces-->
             <a href="page_playlist.php?name_playlist=<?= $playlist['name_playlist']?>"><?= $playlist['name_playlist']?></a><!-- Je dois adapter mais sans la "pageplaylist.php" -->
        <?php endforeach ?>  <!-- Sortie de la boucle -->
    </article>
    <script src="Scripts/script.js"></script>
</body>
</html>