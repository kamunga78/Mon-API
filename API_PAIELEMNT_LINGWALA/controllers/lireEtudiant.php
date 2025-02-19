<?php
// les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF8");
header("Access-Control-Allow-METHODS: GET");

require_once("../config/database.php");
require_once("../models/etudiant.php");

if($_SERVER['REQUEST_METHOD']=="POST"){
    $bdd= new ConnexionDB();
    $db=$bdd->getConnexion();
    // instanciation de la classe Etudian
    $etudiant = new Etudiant($db);
    //recuperation des donnees 
    $stm=$etudiant->lireEtudiant();
    if($stm->rowCount()>0){
        $data=[];
        $data[]=$stm->fetchAll();
        // envoie de donnees 
        http_response_code(200);
        echo json_encode($data);
    }
    else{
        echo json_encode(["Message"=>"ABR"]);
    }
    http_response_code(200);
    echo json_encode(["Message"=>"La methode est autorisée"]);

}
else{
    http_response_code(405);
    echo json_encode(["Message"=>"La methode n'est pas autorisée"]);
}
?>