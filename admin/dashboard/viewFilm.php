<?php
require '../../includes/config.php';
include_once '../../includes/classes/Film.php';
include_once '../../includes/classes/FilmRepository.php';

// Check if the FilmRepository class is correctly loaded


$database = new Database();
$connection = $database->getConnection();

$filmRepository = new classes\FilmRepository($connection);
$films = $filmRepository->getFilmsFromDatabase();
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
            <div class="statistics-film">
                <?php
                echo "<p>List of films:</p>";

                if (!empty($films)) {
                    echo "<table border='1'>
                        <tr>
                            <th>Film ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>";

                    foreach ($films as $film) {
                        echo "<tr>
                            <td>{$film['ID_FILM']}</td>
                            <td>{$film['TITRE']}</td>
                            <td>{$film['DESCRIPTION']}</td>
                            <td>{$film['PRIX']}</td>
                            <td>{$film['CATEGORY']}</td>
                            <td>
                                <button onclick='editFilm({$film['ID_FILM']})'>Edit</button>
                                <button onclick='deleteFilm({$film['ID_FILM']})'>Delete</button>
                            </td>
                        </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>No films found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <nav>
                <ul class="footer-menu">
                    <!-- Add footer menu items as needed -->
                </ul>
                <p class="copyright text-center">
                    © <script>document.write(new Date().getFullYear())</script>
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
        // Initialize charts and notifications as needed
    });
</script>

</html>
