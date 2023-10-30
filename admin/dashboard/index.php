<?php
session_start();

include_once "../../db/config.php";
// Logout
if(isset($_POST['logout_btn']))
{
    session_unset();
    session_destroy();
    header('Location: ../authentication/login.php');
}
?>

<!DOCTYPE html>
<html lang="eng">

<head>
    <title>Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>"></link>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body >

<?php

if(!isset($_SESSION['id_admin']))
{
    header('../../authentication/login.php');
}

include "./adminHeader.php";
include "./sidebar.php";

?>

<div id="main">
    <div id="main-content" class="container position-relative allContent-section py-4">
        <div class="row">
            <div class="col-sm-3">
                <!-- Users count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-users  mb-2 " style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                        <?php
                        $stmt = $this->connection->prepare("SELECT *  from admin WHERE  username= ?");
                        $stmt->bindParam(1, $_SESSION['name']);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                        ?>
                    </h1>
                    <h5 style="color:white;">Adhérents</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Documents count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-book  mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                        <?php
                        $sql = "SELECT count(*) as total from documents";
                        $stmt = $this->connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                        ?>
                    </h1>
                    <h5 style="color:white;">
                        Documents
                    </h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Documents types count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-th-large mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                        <?php
                        $sql = "SELECT count(*) as total from users";
                        $stmt = $this->connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                        ?>
                    </h1>
                    <h5 style="color:white;">Types</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Borrows count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-book mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                        <?php
                        $sql = "SELECT count(*) as total from borrows";
                        $stmt = $this->connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                        ?>
                    </h1>
                    <h5 style="color:white;">Empruntes</h5>
                </div>
            </div>
        </div>

    </div>
</div>


</body>

</html>\