<?php

namespace classes;
class Collection
{
    public $ID_COLLECTION;
    public $ID_ADMIN;
    public $NAME;
    public $DESCRIPTION;
    public $DATE_CREATION;

    public function __construct($ID_COLLECTION, $ID_ADMIN, $NAME, $DESCRIPTION, $DATE_CREATION)
    {
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
}

?>