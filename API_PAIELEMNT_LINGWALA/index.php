<?php
// Inclure les fichiers de configuration
require_once 'config/database.php';

// Démarrer la session (si nécessaire)
session_start();

// Gérer les routes
$page = $_GET['page'] ?? 'accueil'; // Par défaut, afficher la page d'accueil

switch ($page) {
    case 'creer-etudiant':
        require_once 'controllers/CreerEtudiant.php';
        break;
    case 'lire-etudiant':
        require_once 'controllers/lireEtudiant.php';
        break;
    case 'modifier-etudiant':
        require_once 'controllers/modifierEtudiant.php';
        break;
    case 'supprimer-etudiant':
        require_once 'controllers/supprimerEtudiant.php';
        break;
    case 'accueil':
    default:
        // Afficher la page d'accueil
        echo "<h1>Bienvenue sur l'application de gestion des étudiants</h1>";
        echo "<p><a href='?page=creer-etudiant'>Créer un étudiant</a></p>";
        echo "<p><a href='?page=lire-etudiant'>Voir la liste des étudiants</a></p>";
        break;
}
?>
