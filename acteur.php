<?php

class acteur {

    private $acteurid;
    private $nom;
    private $prenom;
    
    // Constructeur
    public function __construct($nom, $prenom) {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    //getters et setters
    public function getActeurid() {
        return $this->acteurid;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setActeurid($acteurid) {
        $this->acteurid = $acteurid;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
}
?>