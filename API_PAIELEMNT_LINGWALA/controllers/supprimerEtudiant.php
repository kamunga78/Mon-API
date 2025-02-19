<?php
// Les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE"); // Utilisation de la méthode DELETE

require_once("../config/database.php");
require_once("../models/etudiant.php");

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $bdd = new ConnexionDB();
    $db = $bdd->getConnexion();
    
    // Instanciation de la classe Etudiant
    $etudiant = new Etudiant($db);
    
    // Récupération des informations envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"));
    
    // Vérification de la présence du Matricule
    if (!empty($data->Matricule)) {
        $etudiant->Matricule = htmlspecialchars($data->Matricule);
        
        // Tentative de suppression de l'étudiant
        if ($etudiant->supprimerEtudiant()) {
            http_response_code(200); // OK
            echo json_encode(array("message" => "Étudiant supprimé avec succès."));
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(array("message" => "Impossible de supprimer l'étudiant."));
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