<?php
class Admin {
    public $ID_ADMIN;
    public $USERNAME;
    public $PASSWORD;

    public function __construct($ID_ADMIN, $USERNAME, $PASSWORD) {
        $this->ID_ADMIN = $ID_ADMIN;
        $this->USERNAME = $USERNAME;
        $this->PASSWORD = $PASSWORD;
    }

    public function printDetails() {
        echo "Admin ID: {$this->ID_ADMIN}, Username: {$this->USERNAME}";
    }
}
