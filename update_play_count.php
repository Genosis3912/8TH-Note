<?php
session_start();

include("connection.php");
include("functions.php");

// Get the song location from the AJAX request
$songloc = $_POST['songloc'];

// Get the audio file path from the song location
$sql = "SELECT file_path FROM audios WHERE file_path LIKE '%$songloc%'";
$result = mysqli_query($con, $sql);
$audio = mysqli_fetch_assoc($result);
$file_path = $audio['file_path'];

// Update the play count for the corresponding song
$sql = "UPDATE audios SET play_count = play_count + 1 WHERE file_path = '$file_path'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo "Play count updated";
} else {
    echo "Error updating play count";
}
?>