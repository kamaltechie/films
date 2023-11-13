<?php
namespace classes;
class Film
{
    private $db;
    public $ID_FILM;
    public $TITRE;
    public $image;
    public $DESCRIPTION;
    public $PRIX;
    public $CATEGORY;

    public function __construct($db, $ID_FILM = null, $TITRE = null, $image = null, $DESCRIPTION = null, $PRIX = null, $CATEGORY = null)
    {
        $this->db = $db;
        $this->ID_FILM = $ID_FILM;
        $this->TITRE = $TITRE;
        $this->image = $image;
        $this->DESCRIPTION = $DESCRIPTION;
        $this->PRIX = $PRIX;
        $this->CATEGORY = $CATEGORY;
    }

    public function getTotalFilm()
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM film");
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result['total'];
        } catch (\PDOException $e) {
            // Handle database connection or query error
            echo "Error: " . $e->getMessage();
            return 0; // Return 0 or handle the error appropriately
        }
    }
}
