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