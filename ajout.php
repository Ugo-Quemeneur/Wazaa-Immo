<?php
include "header.php";
// Vérifie si l'utilisateur est connecté et s'il a le rôle d'administrateur
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: index.php'); // Redirection pour les utilisateurs non autorisés
    exit();
}

$db = ConnexionBase(); // Connexion à la base de données

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
    if (isset($_POST['add_utilisateur'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $nom_utilisateur = $_POST['Nom_Utilisateur'];
        $prenom_utilisateur = $_POST['Prenom_Utilisateur'];
        $mot_de_passe_utilisateur = password_hash($_POST['Mot_De_Passe_Utilisateur'], PASSWORD_DEFAULT);
        $reference_annonce = $_POST['Reference_Annonce'];

        $stmt = $db->prepare("INSERT INTO waz_utilisateur (Nom_Utilisateur, Prenom_Utilisateur, Mot_De_Passe_Utilisateur, Reference_Annonce) VALUES (?, ?, ?, ?,)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$nom_utilisateur, $prenom_utilisateur, $alias_artist, $mot_de_passe_utilisateur, $reference_annonce]);
        echo "Utilisateur ajouté avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_annonce'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $reference_annonce = $_POST['Reference_Annonce'];
        $titre_annonce = $_POST['Titre_Annonce'];
        $description_annonce = $_POST['Description_Annonce'];
        $date_ajout_annonce = $_POST['Date_Ajout_Annonce'];
        $date_modification_annonce = $_POST['Date_Modification_Annonce'];
        $prix_annonce = $_POST['Prix_Annonce'];
        $id_option = $_POST['Id_Option'];
        $id_photo = $_POST['Id_Photo'];

        $stmt = $db->prepare("INSERT INTO waz_annonce (Reference_Annonce, Titre_Annonce, Description_Annonce, Date_Ajout_Annonce, Date_Modification_Annonce, Prix_Annonce, Id_Option, Id_Photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$reference_annonce, $titre_annonce, $description_annonce, $date_ajout_annonce, $date_modification_annonce, $prix_annonce, $id_option, $id_photo]);
        echo "Annonce ajoutée avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_bien'])) {
        $surface_habitable_bien = $_POST['Surface_Habitable_Bien'];
        $surface_totale_bien = $_POST['Surface_Totale_Bien'];
        $nombre_pieces_bien = $_POST['Nombre_Pieces_Bien'];
        $localisation_bien = $_POST['Localisation_Bien'];
        $diagnostic_bien = $_POST['Diagnostic_Bien'];
        $reference_annonce = $_POST['Reference_Annonce'];

        $stmt = $db->prepare("INSERT INTO waz_bien (Surface_Habitable_Bien, Surface_Totale_Bien, Nombre_Pieces_Bien, Localisation_Bien, Diagnostic_Bien, Reference_Annonce) VALUES (?, ?, ?, ?, ?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$surface_habitable_bien, $surface_totale_bien, $nombre_pieces_bien, $localisation_bien, $diagnostic_bien, $reference_annonce]);

        // $id_title = $db->lastInsertId();  Je ne pense pas en avoir besoin mais je garde au cas où
        // $stmt = $db->prepare("INSERT INTO Production (id_title, id_album, id_artist) VALUES (?, ?, ?)"); // Variable qui contient la préparation de la requête SQL
        // $stmt->execute([$id_title, $id_album, $id_artist]);

        echo "Bien ajouté avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_option'])) {
        $libelle_option = $_POST['Libelle_Option'];

        $stmt = $db->prepare("INSERT INTO waz_option (Libelle_Option) VALUES (?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$libelle_option]);

        // $id_album = $db->lastInsertId();   Je ne pense pas en avoir besoin mais je garde au cas où
        // $stmt = $db->prepare("INSERT INTO Production (id_title, id_album, id_artist) VALUES (NULL, ?, ?)"); // Variable qui contient la préparation de la requête SQL
        // $stmt->execute([$id_album, $id_artist]);

        echo "Option ajoutée avec succès."; // Message de confirmation pour l'utilisateur
    }
    elseif (isset($_POST['add_photo'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $url_photo = $_POST['Url_Photo'];
 
        $stmt = $db->prepare("INSERT INTO waz_photo (Url_Photo) VALUES (?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$url_photo]);
        echo "Photo ajoutée avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_type_offre'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $libelle_type_offre = $_POST['Libelle_Type_Offre'];
        $reference_annonce = $_POST['Reference_Annonce'];
 
        $stmt = $db->prepare("INSERT INTO waz_type_offre (Libelle_Type_Offre, Reference_Annonce) VALUES (?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$libelle_type_offre, $reference_annonce]);
        echo "Type d'offre ajoutée avec succès."; // Message de confirmation pour l'utilisateur
    } 
    elseif (isset($_POST['add_type_bien'])) {
        // Déclaration des variables qui contiendront ce que l'admin a entré
        $libelle_type_bien = $_POST['Libelle_Type_Bien'];
        $id_bien = $_POST['Id_Bien'];
 
        $stmt = $db->prepare("INSERT INTO waz_type_bien (Libelle_Type_Bien, Id_Bien) VALUES (?, ?)");  // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$username, $email]);
        echo "Type de bien ajouté avec succès."; // Message de confirmation pour l'utilisateur
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
            document.getElementById('form_utilisateur').style.display = (type === 'utilisateur') ? 'block' : 'none';
            document.getElementById('form_annonce').style.display = (type === 'annonce') ? 'block' : 'none';
            document.getElementById('form_bien').style.display = (type === 'bien') ? 'block' : 'none';
            document.getElementById('form_option').style.display = (type === 'option') ? 'block' : 'none';
            document.getElementById('form_photo').style.display = (type === 'photo') ? 'block' : 'none';
            document.getElementById('form_type_offre').style.display = (type === 'type_offre') ? 'block' : 'none';
            document.getElementById('form_type_bien').style.display = (type === 'type_bien') ? 'block' : 'none';
        }
    </script>
</head>

<body>
    <h1 class="text-center">Ajouter une entité</h1>

    <!-- Sélecteur de type d'entité -->
    <form class="d-flex justify-content-center align-items-center">
        <label>
            <input type="radio" name="entity_type" value="utilisateur" onclick="showForm('utilisateur')"> Utilisateur
        </label>
        <label>
            <input type="radio" name="entity_type" value="annonce" onclick="showForm('annonce')"> Annonce
        </label>
        <label>
            <input type="radio" name="entity_type" value="bien" onclick="showForm('bien')"> Bien
        </label>
        <label>
            <input type="radio" name="entity_type" value="option" onclick="showForm('option')"> Option
        </label>
        <label>
            <input type="radio" name="entity_type" value="photo" onclick="showForm('photo')"> Photo
        </label>
        <label>
            <input type="radio" name="entity_type" value="type_offre" onclick="showForm('type_offre')"> Type d'offre
        </label>
        <label>
            <input type="radio" name="entity_type" value="type_bien" onclick="showForm('type_bien')"> Type de bien
        </label>
    </form>

    <hr>

    <!-- Formulaire pour ajouter un utilisateur -->
    <form id="form_utilisateur" style="display: none;" action="" method="POST">
        <h2>Ajouter un utilisateur</h2>
        <label for="nom_utilisateur">Nom :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>
        <br>
        <br>
        <label for="prenom_utilisateur">Prénom :</label>
        <input type="text" name="prenom_utilisateur" id="prenom_utilisateur" required>
        <br>
        <br>
        <label for="mot_de_passe_utilisateur">Mot de passe :</label>
        <input type="text" name="mot_de_passe_utilisateur" id="mot_de_passe_utilisateur">
        <br>
        <br>
        <label for="reference_annonce">Références des annonces :</label>
        <textarea name="reference_annonce" id="reference_annonce"></textarea>
        <br>
        <br>
        <label for="id_type_utilisateur">Utilisateur :</label>
        <select name="id_type_utilisateur" id="id_type_utiisateur" required>
             <?php foreach ($utilisateur as $utilisateurs): ?> <!-- Boucle pour rajouter un utilisateur -->
                <option value="<?= $utilisateurs['id_type_utilisateur'] ?>"><?= htmlspecialchars($utilisateurs['libelle_type_utilisateur']) ?></option> <!-- Retranscription en HTML -->      A VOIR diff entre artist et artists
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_utilisateur">Ajouter l'utilisateur</button>
    </form>

    <!-- Formulaire pour ajouter une annonce -->
    <form id="form_annonce" style="display: none;" action="" method="POST">
        <h2>Ajouter une annonce</h2>
        <label for="titre_annonce"> Titre de l'annonce :</label>
        <input type="text" name="titre_annonce" id="titre_annonce" required>
        <br>
        <br>
        <label for="description_annonce"> Description de l'annonce :</label>
        <input type="text" name="description_annonce" id="description_annonce" required>
        <br>
        <br>
        <label for="date_ajout_annonce"> Date d'ajout de l'annonce :</label>
        <input type="text" name="date_ajout_annonce" id="date_ajout_annonce" required>
        <br>
        <br>
        <label for="date_modification_annonce"> Prénom :</label>
        <input type="text" name="date_modification_annonce" id="date_modification_annonce" required>
        <br>
        <br>
        <label for="prix_annonce"> Prix de l'annonce :</label>
        <input type="text" name="prix_annonce" id="prix_annonce" required>
        <br>
        <br>
        <label for="id_option"> Options de l'annonce :</label>
        <input type="text" name="id_option" id="id_option" required>
        <br>
        <br>
        <label for="id_photo"> Photo de l'annonce :</label>
        <input type="text" name="id_photo" id="id_photo" required>
        <br>
        <br>
        <!-- <label for="id_type_user"> Type d'utilisateur :</label>
        <select name="id_type_user" id="id_type_user" required>      Le select me perturbe -->
            <?php foreach ($annonce as $annonces): ?> <!-- Boucle pour rajouter un type d'utilisateur -->
                <option value="<?= $annonces['id_annonce'] ?>"><?= htmlspecialchars($annonces['name_annonce']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <button type="submit" name="add_annonce">Ajouter l'annonce</button>
    </form>

    <!-- Formulaire pour ajouter un bien -->
    <form id="form_bien" style="display: none;" action="" method="POST">
        <h2>Ajouter un bien</h2>
        <label for="surface_habitable_bien">Surface habitable du bien :</label>
        <input type="text" name="surface_habitable_bien" id="surface_habitable_bien" required>
        <br>
        <br>
        <label for="surface_totale_bien">Surface totale du bien :</label>
        <input type="text" name="surface_totale_bien" id="surface_totale_bien" required>
        <br>
        <br>
        <label for="nombre_piece_bien">Nombre de pièces :</label>
        <input type="text" name="nombre_pieces_bien" id="nombre_pieces_bien" required>
        <br>
        <br>
        <label for="localisation_bien">Localisation :</label>
        <input type="text" name="localisation_bien" id="localisation_bien" required>
        <br>
        <br>
        <label for="diagnostic_bien">Diagnostic énergétique du bien :</label>
        <input type="text" name="diagnostic_bien" id="diagnostic_bien" required>
        <br>
        <br>
        <label for="diagnostic_bien"></label>
        <select name="diagnostic_bien" id="diagnostic_bien" required>
            <?php foreach ($bien as $biens): ?> <!-- Boucle pour rajouter un genre de musique -->
                <option value="<?= $biens['id_bien'] ?>"><?= htmlspecialchars($biens['name_bien']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_bien">Ajouter le bien</button>
    </form>

    <!-- Formulaire pour ajouter une option -->
    <form id="form_option" style="display: none;" action="" method="POST">
        <h2>Ajouter une option</h2>
        <label for="libelle_option">Libellé de l'option :</label>
        <select name="libelle_option" id="libelle_option" required>
            <?php foreach ($option as $options): ?> <!-- Boucle pour rajouter un artiste -->
                <option value="<?= $options['id_option'] ?>"><?= htmlspecialchars($options['id_option']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_option">Ajouter l'option</button>
    </form>

    <!-- Formulaire pour ajouter une photo -->
    <form id="form_photo" style="display: none;" action="" method="POST">
        <h2>Ajouter une photo</h2>
        <label for="url_photo">URL de la photo :</label>
        <select name="url_photo" id="url_photo" required>
            <?php foreach ($photo as $photos): ?> <!-- Boucle pour rajouter un artiste -->
                <option value="<?= $photos['id_photo'] ?>"><?= htmlspecialchars($photos['id_photo']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_album">Ajouter la photo</button>
    </form>

    <!-- Formulaire pour ajouter un type d'offre -->
    <form id="form_type_offre" style="display: none;" action="" method="POST">
        <h2>Ajouter un type d'offre</h2>
        <label for="libelle_type_offre">Libellé type d'offre :</label>
        <input type="text" name="libelle_type_offre" id="libelle_type_offre" required>
        <br>
        <br>
        <label for="reference_annonce">Référence des annonces :</label>
        <select name="reference_annonce" id="reference_annonce" required>
            <?php foreach ($type_offre as $types_offre): ?> <!-- Boucle pour rajouter un artiste -->
                <option value="<?= $types_offre['id_type_offre'] ?>"><?= htmlspecialchars($types_offre['id_type_offre']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_type_offre">Ajouter le type d'offre</button>
    </form>

    <!-- Formulaire pour ajouter un type de bien -->
    <form id="form_type_bien" style="display: none;" action="" method="POST">
        <h2>Ajouter un type de bien</h2>
        <label for="libelle_type_bien">Libellé du type de bien :</label>
        <input type="text" name="libelle_type_bien" id="libelle_type_bien" required>
        <br>
        <br>
        <label for="id_bien">Id des biens :</label>
        <select name="id_bien" id="id_bien" required>
            <?php foreach ($type_bien as $types_bien): ?> <!-- Boucle pour rajouter un type de bien -->
                <option value="<?= $types_bien['id_type_bien'] ?>"><?= htmlspecialchars($types_bien['id_type_bien']) ?></option> <!-- Retranscription en HTML -->
            <?php endforeach; ?> <!-- Sortie de la boucle -->
        </select>
        <br>
        <br>
        <button type="submit" name="add_type_bien">Ajouter le type de bien</button>
    </form>

</body>
</html>