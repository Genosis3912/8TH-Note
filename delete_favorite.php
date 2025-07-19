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

$sql = "DELETE FROM favorite WHERE id=$id";
if ($conn->query($sql) === TRUE) {
  echo "User deleted successfully";
} else {
  echo "Error deleting user: ". $conn->error;
}
header("Location: profile.php");
$conn->close();
?>