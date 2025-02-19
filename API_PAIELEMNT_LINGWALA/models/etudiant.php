<?php
class Etudiant{
    private $table="etudiant";
    private $connexion=null;

    //les proprietes de l'objet etudiant
    public $Matricule;
    public $Nom;
    public $Postnom;
    public $Prenom;
    public $Sexe;
    public $codPromo;

    public function __construct($db)
    {
        if($this->connexion==null){
            $this->connexion=$db;
        }
    }
    public function lireEtudiant(){
        $sql="Select * from $this->table";
        $req=$this->connexion->query($sql);
        return $req;
    }
    public function CreerEtudiant(){
        $sql="insert into $this->table(Matricule,Postnom,Prenom,Sexe,codPromo) VALUES (:mat,:nom;:post;:prenom,:sexe,:codpromo)";
        // preparation de la requête
        $req=$this->connexion->query($sql);
        // exécution de la requête
        $re=$req->execute(
            [":mat"=>$this->Matricule,
            ":nom"=>$this->Nom,
            ":postnom"=>$this->Postnom,
            ":sexe"=>$this->Sexe,
            ":codpro"=>$this->codPromo]
        );
        if($re){
            return true;
        }else{return false;}

    }
    public function supprimerEtudiant() {
        // Requête SQL pour supprimer un étudiant
        $sql = "DELETE FROM etudiants WHERE Matricule = :Matricule";
        $stmt = $this->connexion->prepare($sql);
        
        // Nettoyage et liaison du paramètre
        $this->Matricule = htmlspecialchars(strip_tags($this->Matricule));
        $stmt->bindParam(":Matricule", $this->Matricule);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function modifierEtudiant() {
        // Requête SQL pour mettre à jour un étudiant
        $sql = "UPDATE etudiants SET 
                Nom = :Nom, 
                Prenom = :Prenom, 
                Sexe = :Sexe 
                WHERE Matricule = :Matricule";
        
        $stmt = $this->connexion->prepare($sql);
        
        // Nettoyage et liaison des paramètres
        $this->Matricule = htmlspecialchars(strip_tags($this->Matricule));
        $this->Nom = htmlspecialchars(strip_tags($this->Nom));
        $this->Prenom = htmlspecialchars(strip_tags($this->Prenom));
        $this->Sexe = htmlspecialchars(strip_tags($this->Sexe));
        
        $stmt->bindParam(":Matricule", $this->Matricule);
        $stmt->bindParam(":Nom", $this->Nom);
        $stmt->bindParam(":Prenom", $this->Prenom);
        $stmt->bindParam(":Sexe", $this->Sexe);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
?>