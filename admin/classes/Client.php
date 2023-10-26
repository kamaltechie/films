<?php
class Client {
    public $ID_CLIENT;
    public $ID_ADMIN;
    public $NOM;
    public $PRENOM;
    public $EMAIL;
    public $ADRESSE;
    public $PASSWORD;

    public function __construct($ID_CLIENT, $ID_ADMIN, $NOM, $PRENOM, $EMAIL, $ADRESSE, $PASSWORD) {
        $this->ID_CLIENT = $ID_CLIENT;
        $this->ID_ADMIN = $ID_ADMIN;
        $this->NOM = $NOM;
        $this->PRENOM = $PRENOM;
        $this->EMAIL = $EMAIL;
        $this->ADRESSE = $ADRESSE;
        $this->PASSWORD = $PASSWORD;
    }

    public function printDetails() {
        echo "Client ID: {$this->ID_CLIENT}, Admin ID: {$this->ID_ADMIN}, Name: {$this->NOM} {$this->PRENOM}, Email: {$this->EMAIL}, Address: {$this->ADRESSE}";
    }
}
