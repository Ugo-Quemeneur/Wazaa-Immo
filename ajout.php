<?php
include "header.php";
// Vérifie si l'utilisateur est connecté et s'il a le rôle d'administrateur
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: index.php'); // Redirection pour les utilisateurs non autorisés
    exit();
}

$db = ConnexionBase(); // Connexion à la base de données

// Types d'utilisateur (Admin, Non connecté, etc.)
$type_utilisateur = $db->query("SELECT * FROM waz_type_utilisateur")->fetchAll(PDO::FETCH_ASSOC);

// Récupére les utilisateurs pour les sélecteurs
$utilisateur = $db->query("SELECT * FROM waz_utilisateur")->fetchAll(PDO::FETCH_ASSOC);

// Récupére les annonces et les biens pour les sélecteurs
$annonce = $db->query("SELECT * FROM waz_annonce")->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes de l'ensemble des résultats de la requête
$bien = $db->query("SELECT * FROM waz_bien")->fetchAll(PDO::FETCH_ASSOC);

// Récupére les options et les photos pour les sélecteurs
$option = $db->query("SELECT * FROM waz_option")->fetchAll(PDO::FETCH_ASSOC);
$photo = $db->query("SELECT * FROM waz_photo")->fetchAll(PDO::FETCH_ASSOC);

// Types d'offre et types de bien
$type_offre = $db->query("SELECT * FROM waz_type_offre")->fetchAll(PDO::FETCH_ASSOC);
$type_bien = $db->query("SELECT * FROM waz_type_bien")->fetchAll(PDO::FETCH_ASSOC);


// Traitement des soumissions de formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_annonce'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $firstname_artist = $_POST['firstname_artist'];
        $lastname_artist = $_POST['lastname_artist'];
        $alias_artist = $_POST['alias_artist'];
        $description_artist = $_POST['description_artist'];
        $id_type_artist = $_POST['id_type_artist'];

        $stmt = $db->prepare("INSERT INTO artist (firstname_artist, lastname_artist, alias_artist, description_artist, id_type_artist) VALUES (?, ?, ?, ?, ?)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$firstname_artist, $lastname_artist, $alias_artist, $description_artist, $id_type_artist]);
        echo "Artiste ajouté avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_user'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstname_user = $_POST['firstname_user'];
        $lastname_user = $_POST['lastname_user'];
        $id_type_user = $_POST['id_type_user'];
        $sexe_user = $_POST['sexe_user'];

        $stmt = $db->prepare("INSERT INTO users (Username, email, password, firstname_user, lastname_user, id_type_user, sexe_user) VALUES (?, ?, ?, ?, ?, ?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$username, $email, $password, $firstname_user, $lastname_user, $id_type_user, $sexe_user]);
        echo "Utilisateur ajouté avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_title'])) {
        $name_title = $_POST['name_title'];
        $time_title = $_POST['time_title'];
        $publication_date_title = $_POST['publication_date_title'];
        $id_genre = $_POST['id_genre'];
        $id_artist = $_POST['id_artist'];
        $id_album = $_POST['id_album'];

        $stmt = $db->prepare("INSERT INTO title (name_title, time_title, publication_date_title, id_genre) VALUES (?, ?, ?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$name_title, $time_title, $publication_date_title, $id_genre]);

        $id_title = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO Production (id_title, id_album, id_artist) VALUES (?, ?, ?)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$id_title, $id_album, $id_artist]);

        echo "Titre ajouté avec succès.";  // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_album'])) {
        $name_album = $_POST['name_album'];
        $publication_date_album = $_POST['publication_date_album'];
        $id_artist = $_POST['id_artist'];

        $stmt = $db->prepare("INSERT INTO album (name_album, publication_date_album) VALUES (?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$name_album, $publication_date_album]);

        $id_album = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO Production (id_title, id_album, id_artist) VALUES (NULL, ?, ?)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$id_album, $id_artist]);

        echo "Album ajouté avec succès."; // Message de confirmation pour l'utilisateur
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une entité</title>
    <script>
        // Script pour afficher/masquer les formulaires en fonction du bouton radio sélectionné
        function showForm(type) {
            document.getElementById('form_artist').style.display = (type === 'artist') ? 'block' : 'none';
            document.getElementById('form_user').style.display = (type === 'user') ? 'block' : 'none';
            document.getElementById('form_title').style.display = (type === 'title') ? 'block' : 'none';
            document.getElementById('form_album').style.display = (type === 'album') ? 'block' : 'none';
        }
    </script>
</head>

<body>
    <h1 class="text-center">Ajouter une entité</h1>

    <!-- Sélecteur de type d'entité -->
    <form class="d-flex justify-content-center align-items-center">
        <label>
            <input type="radio" name="entity_type" value="artist" onclick="showForm('artist')"> Artiste
        </label>
        <label>
            <input type="radio" name="entity_type" value="user" onclick="showForm('user')"> Utilisateur
        </label>
        <label>
            <input type="radio" name="entity_type" value="title" onclick="showForm('title')"> Titre
        </label>
        <label>
            <input type="radio" name="entity_type" value="album" onclick="showForm('album')"> Album
        </label>
    </form>

    <hr>

    <!-- Formulaire pour ajouter un artiste -->
    <form id="form_artist" style="display: none;" action="" method="POST">
        <h2>Ajouter un artiste</h2>
        <label for="firstname_artist">Prénom :</label>
        <input type="text" name="firstname_artist" id="firstname_artist" required>
        <br>
        <br>
        <label for="lastname_artist">Nom :</label>
        <input type="text" name="lastname_artist" id="lastname_artist" required>
        <br>
        <br>
        <label for="alias_artist">Alias :</label>
        <input type="text" name="alias_artist" id="alias_artist">
        <br>
        <br>
        <label for="description_artist">Description :</label>
        <textarea name="description_artist" id="description_artist" required></textarea>
        <br>
        <br>
        <label for="id_type_artist">Type d'artiste :</label>
        <select name="id_type_artist" id="id_type_artist" required>
             <?php foreach ($type_artists as $type_artist): ?> <!-- Boucle pour rajouter un type d'artiste -->
                <option value="<?= $type_artist['id_type_artist'] ?>"><?= htmlspecialchars($type_artist['libelle_type_artist']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_artist">Ajouter l'artiste</button>
    </form>

    <!-- Formulaire pour ajouter un utilisateur -->
    <form id="form_user" style="display: none;" action="" method="POST">
        <h2>Ajouter un utilisateur</h2>
        <label for="username"> Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <br>
        <br>
        <label for="email"> Email :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <br>
        <label for="password"> Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <br>
        <label for="firstname_user"> Prénom :</label>
        <input type="text" name="firstname_user" id="firstname_user" required>
        <br>
        <br>
        <label for="lastname_user"> Nom :</label>
        <input type="text" name="lastname_user" id="lastname_user" required>
        <br>
        <br>
        <label for="id_type_user"> Type d'utilisateur :</label>
        <select name="id_type_user" id="id_type_user" required>
            <?php foreach ($user_types as $type_user): ?> <!-- Boucle pour rajouter un type d'utilisateur -->
                <option value="<?= $type_user['id_type_user'] ?>"><?= htmlspecialchars($type_user['name_type_user']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <label for="sexe_user">Sexe :</label>
        <input type="text" name="sexe_user" id="sexe_user">
        <br>
        <br>
        <button type="submit" name="add_user">Ajouter l'utilisateur</button>
    </form>

    <!-- Formulaire pour ajouter un titre -->
    <form id="form_title" style="display: none;" action="" method="POST">
        <h2>Ajouter un titre</h2>
        <label for="name_title">Nom du titre :</label>
        <input type="text" name="name_title" id="name_title" required>
        <br>
        <br>
        <label for="time_title">Durée :</label>
        <input type="text" name="time_title" id="time_title" required>
        <br>
        <br>
        <label for="publication_date_title">Date de publication :</label>
        <input type="date" name="publication_date_title" id="publication_date_title" required>
        <br>
        <br>
        <label for="id_genre">Genre :</label>
        <select name="id_genre" id="id_genre" required>
            <?php foreach ($music_genres as $genre): ?> <!-- Boucle pour rajouter un genre de musique -->
                <option value="<?= $genre['id_genre'] ?>"><?= htmlspecialchars($genre['name_genre']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <label for="id_artist">Artiste :</label>
        <select name="id_artist" id="id_artist" required>
            <?php foreach ($artists as $artist): ?>  <!-- Boucle pour rajouter un artiste -->
                <option value="<?= $artist['id_artist'] ?>"><?= htmlspecialchars($artist['alias_artist'] ?: $artist['firstname_artist'] . ' ' . $artist['lastname_artist']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <label for="id_album">Album :</label>
        <select name="id_album" id="id_album" required>
            <?php foreach ($albums as $album): ?> <!-- Boucle pour rajouter un album -->
                <option value="<?= $album['id_album'] ?>"><?= htmlspecialchars($album['name_album']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_title">Ajouter le titre</button>
    </form>

    <!-- Formulaire pour ajouter un album -->
    <form id="form_album" style="display: none;" action="" method="POST">
        <h2>Ajouter un album</h2>
        <label for="name_album">Nom de l'album :</label>
        <input type="text" name="name_album" id="name_album" required>
        <br><br>
        <label for="publication_date_album">Date de publication :</label>
        <input type="date" name="publication_date_album" id="publication_date_album" required>
        <br>
        <br>
        <label for="id_artist">Artiste :</label>
        <select name="id_artist" id="id_artist" required>
            <?php foreach ($artists as $artist): ?> <!-- Boucle pour rajouter un artiste -->
                <option value="<?= $artist['id_artist'] ?>"><?= htmlspecialchars($artist['alias_artist'] ?: $artist['firstname_artist'] . ' ' . $artist['lastname_artist']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_album">Ajouter l'album</button>
    </form>

</body>
</html>