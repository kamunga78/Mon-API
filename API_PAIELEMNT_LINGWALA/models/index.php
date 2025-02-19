<?php
require_once("../config/database.php");
$test_con= new ConnexionDB();


if($test_con->getConnexion()){
    echo "Vous êtes connecté !!";
}
else{
    echo "Pas de connexion";
}
?>