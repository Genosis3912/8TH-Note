<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "8thnote_db";

// Create connection
$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

$id = $_GET['id'];

$sqlSongs = "DELETE FROM audios WHERE user_id=$id";
if ($conn->query($sqlSongs) === TRUE) {
    echo "Songs deleted successfully<br>";
} else {
    echo "Error deleting songs";
}

// Delete user
$sqlUser = "DELETE FROM users WHERE id=$id";
if ($conn->query($sqlUser) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user: ";
}

$conn->close();

header("Location: admin.php");
?>