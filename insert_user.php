<?php
session_start();

include("connection.php");
include("functions.php");

// Create connection
$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

$email = $_POST['email'];
$user_name = $_POST['user_name'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT); //creating a hashed password
$access_level = $_POST['access_level'];

$sql = "INSERT INTO users (email, user_name, password, access_level) VALUES ('$email', '$user_name', '$hashed_password', '$access_level')";

if ($conn->query($sql) === TRUE) {
  header("Location: admin.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>