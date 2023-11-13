<?php
require '../../includes/config.php';
include_once '../../includes/classes/collectionRepository.php';
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
            <div class="statistics-collection">
                <?php
                $database = new Database();
                $connection = $database->getConnection();

                $collectionRepository = new classes\collectionRepository($connection);

                $collections = $collectionRepository->getCollectionsFromDatabase();
                echo "<p>List of collections:</p>";

                if (!empty($collections)) {
                    echo "<table border='1'>
        <tr>
            <th>Collection ID</th>
            <th>Admin ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date Creation</th>
            <th>Action</th>
        </tr>";

                    foreach ($collections as $collection) {
                        echo "<tr>
            <td>{$collection['ID_COLLECTION']}</td>
            <td>{$collection['ID_ADMIN']}</td>
            <td>{$collection['NAME']}</td>
            <td>{$collection['DESCRIPTION']}</td>
            <td>{$collection['DATE_CREATION']}</td>
            <td>
                <!-- Add buttons for actions on the collection -->
                <button onclick='editCollection({$collection['ID_COLLECTION']})'>Edit</button>
                <button onclick='deleteCollection({$collection['ID_COLLECTION']})'>Delete</button>
            </td>
        </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>No collections found.</p>";
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
<script>
    function editCollection(collectionId) {
        // Implement the logic for editing collection, for example, redirect to an edit page
        window.location.href = 'editCollection.php?id=' + collectionId;
    }

    function deleteCollection(collectionId) {
        if (confirm('Do you want to delete this collection?')) {
            $.ajax({
                type: 'POST',
                url: '../Views/ajaxHandler.php', // Update the correct path
                data: {
                    action: 'deleteCollection',
                    collectionId: collectionId
                },
                success: function (response) {
                    if (response.trim().toLowerCase() === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to delete the collection.');
                    }
                },
                error: function () {
                    alert('An error occurred while processing the request.');
                }
            });
        }
    }

</script>


</html>
