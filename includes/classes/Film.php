<?php
namespace classes;

class Film
{
    public $ID_FILM;
    public $TITRE;

    public $image;
    public $DESCRIPTION;
    public $PRIX;
    public $CATEGORY;


    public function __construct($ID_FILM, $TITRE, $image, $DESCRIPTION, $PRIX, $CATEGORY)
    {
        $this->ID_FILM = $ID_FILM;
        $this->TITRE = $TITRE;
        $this->image = $image;
        $this->DESCRIPTION = $DESCRIPTION;
        $this->PRIX = $PRIX;
        $this->CATEGORY = $CATEGORY;
    }

    public function printDetails()
    {
        echo "ID: {$this->ID_FILM}, Title: {$this->TITRE}, Description: {$this->DESCRIPTION}, Price: {$this->PRIX}, Category: {$this->CATEGORY}, Status: {$this->STATUT}";
    }
}