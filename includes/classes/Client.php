<?php
namespace classes;

class Client
{
    private $connection;
    public $ID_CLIENT;
    public $ID_ADMIN;
    public $NOM;
    public $PRENOM;
    public $EMAIL;
    public $ADRESSE;
    public $PASSWORD;

    public function __construct($connection, $ID_CLIENT = null, $ID_ADMIN = null, $NOM = null, $PRENOM = null, $EMAIL = null, $ADRESSE = null, $PASSWORD = null)
    {
        $this->connection = $connection;
        $this->ID_CLIENT = $ID_CLIENT;
        $this->ID_ADMIN = $ID_ADMIN;
        $this->NOM = $NOM;
        $this->PRENOM = $PRENOM;
        $this->EMAIL = $EMAIL;
        $this->ADRESSE = $ADRESSE;
        $this->PASSWORD = $PASSWORD;
    }

    public function createEmptyClient()
    {
        $this->ID_CLIENT = null;
        $this->ID_ADMIN = null;
        $this->NOM = null;
        $this->PRENOM = null;
        $this->EMAIL = null;
        $this->ADRESSE = null;
        $this->PASSWORD = null;
    }

    public function printDetails()
    {
        echo "Client ID: {$this->ID_CLIENT}, Admin ID: {$this->ID_ADMIN}, Name: {$this->NOM} {$this->PRENOM}, Email: {$this->EMAIL}, Address: {$this->ADRESSE}";
    }

    public function getTotalUser()
    {
        $query = "SELECT COUNT(*) as TOTAL FROM CLIENT";
        $stmnt = $this->connection->prepare($query);
        if ($stmnt->execute()) {
            $result = $stmnt->fetch(\PDO::FETCH_ASSOC);
            return $result['TOTAL'];
        } else {
            return false;
        }
    }
}
