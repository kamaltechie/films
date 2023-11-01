<?php

namespace classes;
class Commande
{
    public $NUM_COM;
    public $ID_CLIENT;
    public $DATE_COM;
    public $STATUT_COM;
    public $TOTAL;

    public function __construct($NUM_COM, $ID_CLIENT, $DATE_COM, $STATUT_COM, $TOTAL)
    {
        $this->NUM_COM = $NUM_COM;
        $this->ID_CLIENT = $ID_CLIENT;
        $this->DATE_COM = $DATE_COM;
        $this->STATUT_COM = $STATUT_COM;
        $this->TOTAL = $TOTAL;
    }

    public function printDetails()
    {
        echo "Command Number: {$this->NUM_COM}, Customer ID: {$this->ID_CLIENT}, Date: {$this->DATE_COM}, Status: {$this->STATUT_COM}, Total: {$this->TOTAL}";
    }
}

?>