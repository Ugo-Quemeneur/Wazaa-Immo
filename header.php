<?php
session_start(); // Commencer une session, fonction native

function ConnexionBase() // Fonction pour se connecter à la base de données
{ // Infos pour trouver la BDD
    $host = 'localhost';
    $dbname = 'wazaa';
    $username = 'root';
    $password = '';
    try {
        $connexion = new PDO( // Connexion entre PHP et la BDD
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $username,
            $password
        );
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Juste pour une erreur 
        return $connexion;
    } catch (Exception $e) { // Attraper l'exception, si ça ne se connecte pas à la BDD
        echo "Erreur : " . $e->getMessage() . "<br>";
        echo "N° : " . $e->getCode();
        die("Fin du script");
    }
}
$db = ConnexionBase(); // Connexion à la base de données

// Vérifie si l'utilisateur est admin
$isAdmin = isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['Admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <img src="img\wazaa_logo.png" alt="Logo du site Wazaa Immo">
        <h2>Wazaa Immo, le foyer qu'il vous faut</h2>
        <!-- <p>Juste pour tester si ça fonctionne bien</p>
        <p>Yeepee!</p>  -->
    </header>
