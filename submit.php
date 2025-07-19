<?php


include("connection.php");
include("functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    // Create connection
    $conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO request (user_name, email, messages) VALUES ('$user_name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        
        header("Location: home.php");
        ?>
        <script>alert("Request created successfully");</script>
        <?php
    } else {
        echo "Error: ". $sql. "<br>". $conn->error;
    }

    $conn->close();
}
?>