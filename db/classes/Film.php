<?php
namespace classes;

class Film
{
    private $connection;
    public $ID_FILM;
    public $TITRE;

    public $image;
    public $DESCRIPTION;
    public $PRIX;
    public $CATEGORY;
    public $STATUT;


public function __construct($connection,$ID_FILM, $TITRE, $image, $DESCRIPTION, $PRIX, $CATEGORY, $STATUT)
{
    $this->connection=$connection;
    $this->ID_FILM = $ID_FILM;
    $this->TITRE = $TITRE;
    $this->image = $image;
    $this->DESCRIPTION = $DESCRIPTION;
    $this->PRIX = $PRIX;
    $this->CATEGORY = $CATEGORY;
    $this->STATUT = $STATUT;
}

public function printDetails()
{
echo "ID: {$this->ID_FILM}, Title: {$this->TITRE}, Description: {$this->DESCRIPTION}, Price: {$this->PRIX}, Category: {$this->CATEGORY}, Status: {$this->STATUT}";
}


    public function getTotalFilm()
    {
        $query = "SELECT COUNT(*) as TOTAL FROM FILM";
        $stmnt = $this->connection->prepare($query);
        if ($stmnt->execute()) {
            $result = $stmnt->fetch(\PDO::FETCH_ASSOC);
            return $result['TOTAL'];
        } else {
            return false;
        }
    }
}
