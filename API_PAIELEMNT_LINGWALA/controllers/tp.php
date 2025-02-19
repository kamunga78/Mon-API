<?php
// Les entêtes requises
Header("Access-Control-Allow-Origin :") ;
Header("Content-type : application/json ; charset=UTF-8 ") ;
Header("Access-Control-Allow-METHODS : POST") ;

Require_once("../config/database.php ") ;
Require_once("../models/etudiant.php") ;

If ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bdd = new ConnexionDB() ;
    $db = $bdd->getConnexion() ;

    // Instanciation de la classe étudiant
    $etudiant = new Etudiant($db) ;

    // Détection du type de contenu
    $contentType = $_SERVER["CONTENT_TYPE "] ?? "application/json" ;
    $input = file_get_contents("php://input ") ;

    If ($contentType == "application/json") {
        $data = json_decode($input) ;
    } elseif ($contentType == "application/xml") {
        $data = simplexml_load_string($input) ;
    } elseif ($contentType == "application/x-yaml " || $contentType == "text/yaml") {
        $data = yaml_parse($input) ;
    } else {
        http_response_code(400) ;
        echo json_encode([" message » => « Format non supporté "]) ;
        exit ;
    }

    If ( !empty($data->Matricule)) {
        $etudiant->Matricule = htmlspecialchars($data->Matricule) ;
        $etudiant->Nom = htmlspecialchars($data->Nom) ;
        $etudiant->Prenom = htmlspecialchars($data->Prenom) ;
        $etudiant->Sexe = htmlspecialchars($data->Sexe) ;

        // Ici, tu peux ajouter l’insertion en base de données

        http_response_code(201) ;
        echo json_encode([ "message"=> "Étudiant créé avec succès"]) ;
    } else {
        http_response_code(400) ;
        echo json_encode(["message " => "Données invalides"]) ;
    }
}
?>
