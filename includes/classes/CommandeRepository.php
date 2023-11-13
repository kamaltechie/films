<?php

namespace classes;
class CommandeRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAllCommandes()
    {
        $query = "SELECT * FROM COMMANDE";
        $stmnt = $this->connection->prepare($query);

        if ($stmnt->execute()) {
            $result = $stmnt->fetchAll(\PDO::FETCH_ASSOC);

            $commandes = [];
            foreach ($result as $row) {
                $commande = new Commande(
                    $this->connection,
                    $row['NUM_COM'],
                    $row['ID_CLIENT'],
                    $row['DATE_COM'],
                    $row['STATUT_COM'],
                    $row['TOTAL']
                );

                $commandes[] = $commande;
            }

            return $commandes;
        } else {
            // Gestisci eventuali errori nell'esecuzione della query
            return false;
        }
    }


    // ... (nel tuo CommandeRepository.php)
    function acceptCommande($numCom) {
        $query = "UPDATE COMMANDE SET STATUT_COM = 'accepted' WHERE NUM_COM = :numCom";
        $stmnt = $this->connection->prepare($query);
        $stmnt->bindParam(':numCom', $numCom, \PDO::PARAM_INT);

        if ($stmnt->execute()) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }

    // ... (nel tuo CommandeRepository.php)
    function refuseCommande($numCom) {
        $query = "UPDATE COMMANDE SET STATUT_COM = 'refused' WHERE NUM_COM = :numCom";
        $stmnt = $this->connection->prepare($query);
        $stmnt->bindParam(':numCom', $numCom, \PDO::PARAM_INT);

        if ($stmnt->execute()) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }

    function deleteCommande($numCom) {
        $query = "DELETE FROM COMMANDE WHERE NUM_COM = :numCom";
        $stmnt = $this->connection->prepare($query);
        $stmnt->bindParam(':numCom', $numCom, \PDO::PARAM_INT);

        if ($stmnt->execute()) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }

}

?>
