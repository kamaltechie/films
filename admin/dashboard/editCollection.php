<?php
require '../../includes/config.php';
include_once '../../includes/classes/CollectionRepository.php';

// Check if collection ID is provided in the URL
if (isset($_GET['id'])) {
    $collectionId = $_GET['id'];

    $database = new Database();
    $connection = $database->getConnection();
    $collectionRepository = new classes\CollectionRepository($connection);

    // Fetch collection details based on the ID
    $collectionDetails = $collectionRepository->getCollectionDetailsById($collectionId);

    if ($collectionDetails) {
        // Display the collection details in a form for editing
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <!-- Add your head content, including stylesheets and scripts -->
            <title>Edit Collection</title>
        </head>

        <body>
        <h2>Edit Collection</h2>
        <form action="updateCollection.php" method="post">
            <!-- Add form fields to edit collection details -->
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $collectionDetails['NAME']; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description"><?php echo $collectionDetails['DESCRIPTION']; ?></textarea>

            <input type="hidden" name="id" value="<?php echo $collectionId; ?>">
            <input type="submit" value="Update Collection">
        </form>
        </body>

        </html>
        <?php
    } else {
        echo 'Collection not found.';
    }
} else {
    echo 'Collection ID is missing.';
}
?>
