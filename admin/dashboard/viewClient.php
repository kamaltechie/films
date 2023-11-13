<?php
require '../../includes/config.php';
include_once '../../includes/classes/Client.php';
include_once '../../includes/classes/ClientRepository.php';

$database = new Database();
$connection = $database->getConnection();

$clientRepository = new classes\ClientRepository($connection);
$clients = $clientRepository->getClientsFromDatabase();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link href="../assets/css/style4.css" rel="stylesheet">
</head>

<body>
<?php include 'sidebar.php'; ?>

<div class="statistics">
    <div class="statistics-client">
        <?php
        echo "<p>List of clients:</p>";

        if (!empty($clients)) {
            echo "<table border='1'>
                <tr>
                    <th>Client ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>";

            foreach ($clients as $client) {
                echo "<tr>
                    <td>{$client['ID_CLIENT']}</td>
                    <td>{$client['NOM']} {$client['PRENOM']}</td>
                    <td>{$client['EMAIL']}</td>
                    <td>{$client['ADRESSE']}</td>
                    <td>
                        <button onclick='editClient({$client['ID_CLIENT']})'>Edit</button>
                        <button onclick='deleteClient({$client['ID_CLIENT']})'>Delete</button>
                    </td>
                </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No clients found.</p>";
        }
        ?>
    </div>
</div>
</body>
<script src="../assets/js/functions.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize charts and notifications as needed
    });
</script>

</html>
