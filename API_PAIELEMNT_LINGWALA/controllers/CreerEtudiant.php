<?php
// Les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once("../config/database.php");
require_once("../models/etudiant.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $bdd = new ConnexionDB();
    $db = $bdd->getConnexion();
    
    // Instanciation de la classe Etudiant
    $etudiant = new Etudiant($db);
    
    // Récupération des informations envoyées par le formulaire
    $data = json_decode(file_get_contents("php://input"));
    
    if (!empty($data->Matricule) && !empty($data->Nom) && !empty($data->Prenom) && !empty($data->Sexe)) {
        $etudiant->Matricule = htmlspecialchars($data->Matricule);
        $etudiant->Nom = htmlspecialchars($data->Nom);
        $etudiant->Prenom = htmlspecialchars($data->Prenom);
        $etudiant->Sexe = htmlspecialchars($data->Sexe);
        
        // Tentative d'enregistrement de l'étudiant
        if ($etudiant->CreerEtudiant()) {
            http_response_code(201); // Created
            echo json_encode(array("message" => "Étudiant créé avec succès."));
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(array("message" => "Impossible de créer l'étudiant."));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Données incomplètes."));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>