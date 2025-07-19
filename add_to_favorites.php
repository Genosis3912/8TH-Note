<?php
// Connect to the database
include("connection.php");
include("functions.php");
// Check connection
if (!$con) {
    die("Connection failed: ". mysqli_connect_error());
}

// Get the current song ID and user ID from the session or wherever they are stored
$songId = $_GET['song_id'];
$userId = $_GET['user_id'];

if($userId > 0){
// Check if the song and user already exist in the favorite table
$check_query = "SELECT * FROM favorite WHERE user_id = $userId AND song_id = $songId";
$check_result = mysqli_query($con, $check_query);

// If the song and user do not exist in the favorite table, add them
if (mysqli_num_rows($check_result) == 0) {
    $sql = "INSERT INTO favorite (user_id, song_id ) VALUES ('$userId', '$songId')";

    if (mysqli_query($con, $sql)) {
        echo "Song added to favorites successfully!";
    } else {
        echo "Error: " . $sql. "<br>" . mysqli_error($conn);
    }
} else {
    echo "Song already in favorites.";
}
header( 'Location: library.php' );
}
else{
    header( 'Location: login.php' ); 
}
// Close the connection
mysqli_close($con);
?>