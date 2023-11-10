<?php

    require '../../db/config.php';
    include_once '../../db/classes/Client.php';
    include_once '../../db/classes/Collection.php';
    include_once '../../db/classes/Commande.php';
    include_once '../../db/classes/Film.php';

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
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
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
        <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
-->
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                    ADMIN PANEL
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.html">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./collection.html">
                        <i class="nc-icon nc-circle-09"></i>
                        <p href="collections.php">Collections</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./users.html">
                        <i class="nc-icon nc-notes"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./viewCommande.php">
                        <i class="nc-icon nc-paper-2"></i>
                        <p>Commande</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./film.html">
                        <i class="nc-icon nc-atom"></i>
                        <p>Films</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg " color-on-scroll="500">
            <div class="container-fluid">
                <a class="navbar-brand" href="#pablo"> Dashboard </a>
                <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar burger-lines"></span>
                    <span class="navbar-toggler-bar burger-lines"></span>
                    <span class="navbar-toggler-bar burger-lines"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="d-lg-block">&nbsp;Search</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../authentication/login.php?logout=true">
                                <span class="no-icon">Log out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="statistics">
            <div class="statistics-user">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $client = new classes\Client($connection);
                $total_user= $client->getTotalUser();
                echo "<h1>Total user subscribed:   $total_user</h1> ";
                ?>
            </div>
            <div class="statistics-collections">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $collection =new classes\Collection($connection,null,null,null,null,null);
                $total_collections=$collection->getTotalCollections();
                echo "<h1>Total collection:   $total_collections</h1> ";
                ?>
            </div>



            <div class="statistics-commande">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $commande =new classes\Commande($connection,null,null,null,null,null);
                $total_commande=$commande->getTotalCommande();
                echo "<h1>Total commande:   $total_commande</h1> ";
                ?>

            </div>


            <div class="statistics-films">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $film =new classes\Film($connection,null,null,null,null,null,null,null);
                $total_film=$film->getTotalFilm();
                echo "<h1>Film in our databases:   $total_film</h1> ";
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
