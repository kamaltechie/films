<?php
require '../../includes/config.php';
include_once '../../includes/classes/Commande.php';
include_once '../../includes/classes/CommandeRepository.php';
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link href="../assets/css/style4.css" rel="stylesheet">
</head>

<body>
<?php include 'sidebar.php'; ?>
       <div class="statistics-commande">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $commande = new classes\Commande($connection, null, null, null, null, null);
                $total_commande = $commande->getTotalCommande();
                echo "<h1>Total commande:   $total_commande</h1>";

                $commande_detail = new classes\CommandeRepository($connection);

                $details_commandes = $commande_detail->getAllCommandes();
                echo "<p>List of commandes:</p>";

                // Verifica se ci sono commandes prima di generare la tabella
                if (!empty($details_commandes)) {
                    echo "<table border='1'>
            <tr>
                <th>Command Number</th>
                <th>Customer ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>";

                    foreach ($details_commandes as $commande) {
                        echo "<tr>
                <td>{$commande->NUM_COM}</td>
                <td>{$commande->ID_CLIENT}</td>
                <td>{$commande->DATE_COM}</td>
                <td>{$commande->STATUT_COM}</td>
                <td>{$commande->TOTAL}</td>
                <td>
                    <button onclick='acceptCommande({$commande->NUM_COM})'>Accept</button>
                    <button onclick='refuseCommande({$commande->NUM_COM})'>Refuse</button>
                    <button onclick='deleteCommande({$commande->NUM_COM})'>Delete</button>
                </td>
            </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>No commandes found.</p>";
                }

                // Aggiungi uno script JavaScript per gestire il clic sui pulsanti
                echo "<script>

        function acceptCommande(commandNumber) {
                if (confirm('Do you want to accept this Commande?')) {
                    $.ajax({
                    type: 'POST',
                    url: '../Views/ajaxHandler.php', // Sostituire con il percorso corretto
                    data: {
                        action: 'acceptCommande',
                        numCom: commandNumber
                },
                    success: function (response) {
                // La tua funzione PHP ritorna true o false, verifica la risposta
                    if (response.trim().toLowerCase() === 'success') {
                    // Se l'operazione nel backend ha avuto successo, ricarica la pagina
                    location.reload();
                    } else {
                    // Se c'è stato un problema nel backend, mostra un messaggio di errore
                    alert('Failed to accept the Commande.');
                    }
                    },
            error: function () {
                // Gestisci gli errori di connessione o altri errori
                alert('An error occurred while processing the request.');
            }
        });
    }
        }


       // ... (nel tuo frontend)
       function refuseCommande(commandNumber) {
                if (confirm('Do you want to refuse this Commande?')) {
                    $.ajax({
                        type: 'POST',
                        url: '../Views/ajaxHandler.php', // Aggiorna il percorso corretto
                        data: {
                            action: 'refuseCommande',
                            numCom: commandNumber
                        },
                    success: function (response) {
                        // La tua funzione PHP ritorna true o false, verifica la risposta
                        if (response.trim().toLowerCase() === 'success') {
                            // Se l'operazione nel backend ha avuto successo, ricarica la pagina o esegui altre operazioni
                            location.reload();
                        } else {
                            // Se c'è stato un problema nel backend, mostra un messaggio di errore
                            alert('Failed to refuse the Commande.');
                        }
                    },
                    error: function () {
                        // Gestisci gli errori di connessione o altri errori
                        alert('An error occurred while processing the request.');
                    }
                });
    }
}


        function deleteCommande(commandNumber) {
    if (confirm('Do you want to delete this Commande?')) {
        $.ajax({
            type: 'POST',
            url: '../Views/ajaxHandler.php', // Aggiorna il percorso corretto
            data: {
                action: 'deleteCommande',
                numCom: commandNumber
            },
            success: function (response) {
                // La tua funzione PHP ritorna true o false, verifica la risposta
                if (response.trim().toLowerCase() === 'success') {
                    // Se l'operazione nel backend ha avuto successo, ricarica la pagina o esegui altre operazioni
                    location.reload();
                } else {
                    // Se c'è stato un problema nel backend, mostra un messaggio di errore
                    alert('Failed to delete the Commande.');
                }
            },
            error: function () {
                // Gestisci gli errori di connessione o altri errori
                alert('An error occurred while processing the request.');
            }
        });
    }
}






        
      </script>";
                ?>

            </div>



        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <nav>
                <ul class="footer-menu">
                </ul>
                <p class="copyright text-center">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </p>
            </nav>
        </div>
    </footer>
</div>
</div>

</body>
<script src="../assets/js/functions.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.showNotification();

    });
</script>



</html>

