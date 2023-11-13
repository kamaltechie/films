<?php

namespace classes;
class Collection
{


    private $connection; // Assumendo che tu abbia una proprietà per la connessione al database

    public $ID_COLLECTION;
    public $ID_ADMIN;
    public $NAME;
    public $DESCRIPTION;
    public $DATE_CREATION;

    public function __construct($connection,$ID_COLLECTION, $ID_ADMIN, $NAME, $DESCRIPTION, $DATE_CREATION)
    {
        $this->connection=$connection;
        $this->ID_COLLECTION = $ID_COLLECTION;
        $this->ID_ADMIN = $ID_ADMIN;
        $this->NAME = $NAME;
        $this->DESCRIPTION = $DESCRIPTION;
        $this->DATE_CREATION = $DATE_CREATION;
    }

    public function printDetails()
    {
        echo "Collection ID: {$this->ID_COLLECTION}, Admin ID: {$this->ID_ADMIN}, Name: {$this->NAME}, Description: {$this->DESCRIPTION}, Date of Creation: {$this->DATE_CREATION}";
    }

    public function getTotalCollections()
    {
        $query = "SELECT COUNT(*) as TOTAL FROM COLLECTION";
        $stmnt = $this->connection->prepare($query);
        if ($stmnt->execute()) {
            $result = $stmnt->fetch(\PDO::FETCH_ASSOC);
            return $result['TOTAL'];
        } else {
            return false;
        }
    }
}

?>