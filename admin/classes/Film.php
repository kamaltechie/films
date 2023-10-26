<?php
class Film {
    public $ID_FILM;
    public $TITRE;
    public $DESCRIPTION;
    public $PRIX;
    public $CATEGORY;
    public $STATUT;

    public function __construct($ID_FILM, $TITRE, $DESCRIPTION, $PRIX, $CATEGORY, $STATUT) {
        $this->ID_FILM = $ID_FILM;
        $this->TITRE = $TITRE;
        $this->DESCRIPTION = $DESCRIPTION;
        $this->PRIX = $PRIX;
        $this->CATEGORY = $CATEGORY;
        $this->STATUT = $STATUT;
    }

    public function printDetails() {
        echo "ID: {$this->ID_FILM}, Title: {$this->TITRE}, Description: {$this->DESCRIPTION}, Price: {$this->PRIX}, Category: {$this->CATEGORY}, Status: {$this->STATUT}";
    }
}
?>