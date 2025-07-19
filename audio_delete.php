<?php
require_once 'connection.php'; // Assuming you have a database connection file

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM audios WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('Location: admin.php'); // Replace 'index.php' with the name of your current PHP file
    } else {
        echo "Error: ". $sql. "<br>". mysqli_error($con);
    }
}
?>