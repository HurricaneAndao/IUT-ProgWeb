<?php
class film {

    private $filmid;
    private $titre;
    private $annee;
    private $note;

    
    // Constructeur
    public function __construct($titre, $annee, $note) {
        $this->titre = $titre;
        $this->annee = $annee;
        $this->note = $note;
    }

    //getters et setters
    function getFilmid() {
        return $this->filmid;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function getNote() {
        return $this->note;
    }
    
    public function setFilmid($filmid) {
        $this->filmid = $filmid;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

    public function setNote($note) {
        $this->note = $note;
    }

}


