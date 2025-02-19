<?php
// Les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT"); // Utilisation de la méthode PUT

require_once("../config/database.php");
require_once("../models/etudiant.php");

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $bdd = new ConnexionDB();
    $db = $bdd->getConnexion();
    
    // Instanciation de la classe Etudiant
    $etudiant = new Etudiant($db);
    
    // Récupération des informations envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"));
    
    // Vérification de la présence du Matricule et des données à mettre à jour
    if (!empty($data->Matricule)) {
        $etudiant->Matricule = htmlspecialchars($data->Matricule);
        
        // Mise à jour des champs si ils sont fournis
        if (!empty($data->Nom)) {
            $etudiant->Nom = htmlspecialchars($data->Nom);
        }
        if (!empty($data->Prenom)) {
            $etudiant->Prenom = htmlspecialchars($data->Prenom);
        }
        if (!empty($data->Sexe)) {
            $etudiant->Sexe = htmlspecialchars($data->Sexe);
        }
        
        // Tentative de mise à jour de l'étudiant
        if ($etudiant->modifierEtudiant()) {
            http_response_code(200); // OK
            echo json_encode(array("message" => "Étudiant mis à jour avec succès."));
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(array("message" => "Impossible de mettre à jour l'étudiant."));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Matricule manquant."));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>