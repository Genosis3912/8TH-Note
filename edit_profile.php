<?php
session_start();
// Connect to the database
include ("connection.php");
include ("functions.php");
// Get the current user data
$user_id = $_SESSION['id'];
$user_data = get_user_data($con, $user_id);

// Function to check the old password
function check_old_password($con, $user_id, $old_password)
{
    $old_password = mysqli_real_escape_string($con, $old_password);
    $query = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);
    return password_verify($old_password, $user_data['password']);
}

// Check if the user has submitted any changes
if (isset($_POST['name']) &&!empty($_POST['name']) && isset($_POST['old_password']) &&!empty($_POST['old_password'])) {
    // Check the old password
    if (check_old_password($con, $user_id, $_POST['old_password'])) {
        // Update the name in the database
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $query = "UPDATE users SET user_name = '$name' WHERE id = $user_id";
        mysqli_query($con, $query);
    } else {
        // Handle incorrect old password
        ?><script> alert("Wrong password."); </script><?php
    }
}

if (isset($_POST['email']) &&!empty($_POST['email']) && isset($_POST['old_password']) &&!empty($_POST['old_password'])) {
    // Check the old password
    if (check_old_password($con, $user_id, $_POST['old_password'])) {
        // Update the email in the database
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $query = "UPDATE users SET email = '$email' WHERE id = $user_id";
        mysqli_query($con, $query);
    } else {
        // Handle incorrect old password
        ?><script> alert("Wrong password."); </script><?php
    }
}

if (isset($_POST['password']) &&!empty($_POST['password']) && isset($_POST['old_password']) &&!empty($_POST['old_password'])) {
    // Check the old password
    if (check_old_password($con, $user_id, $_POST['old_password'])) {
        // Update the password in the database
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); //creating a hashed password

        $query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
        mysqli_query($con, $query);
    } else {
        // Handle incorrect old password
        ?><script> alert("Wrong password."); </script><?php
    }
}

// Redirect the user to the profile page
header("Location: profile.php");
exit;

// Function to get the user data from the database
function get_user_data($con, $user_id)
{
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);
    return $user_data;
}
?>