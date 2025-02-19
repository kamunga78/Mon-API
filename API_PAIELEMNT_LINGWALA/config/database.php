<?php
class ConnexionDB {
    private $host = "localhost";
    private $dbname = "conception";
    private $username = "root";
    private $passw = "";

    public function getConnexion() {
        $conn = null;
        try {
            $conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=3306;charset=utf8",
                $this->username, $this->passw,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            // Vous pouvez également logger l'erreur ici
        }
        return $conn;
    }
}


?>
