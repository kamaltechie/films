<?php
namespace classes;

class Film
{
public $ID_FILM;
public $TITRE;
public $DESCRIPTION;
public $PRIX;
public $CATEGORY;
public $STATUT;

public $image;

public function __construct($ID_FILM, $TITRE, $DESCRIPTION, $PRIX, $CATEGORY, $STATUT, $image)
{
$this->ID_FILM = $ID_FILM;
$this->TITRE = $TITRE;
$this->DESCRIPTION = $DESCRIPTION;
$this->PRIX = $PRIX;
$this->CATEGORY = $CATEGORY;
$this->STATUT = $STATUT;
$this->image = $image; // Initialize the image property
}

public function printDetails()
{
echo "ID: {$this->ID_FILM}, Title: {$this->TITRE}, Description: {$this->DESCRIPTION}, Price: {$this->PRIX}, Category: {$this->CATEGORY}, Status: {$this->STATUT}";
}
}
