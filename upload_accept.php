<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Get the variables from the URL
$songName = $_GET['songname'];
$artistName = $_GET['artist'];
$file_path = $_GET['file'];
$id = $_GET['id'];
$user_id = $_GET['user_id'];
// Extract the file name and extension from the file path
$fileName = basename($file_path);
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

// Check if the file extension is allowed
$allowed = array('mp3', 'wav', 'ogg', 'm4a');
if(in_array($fileActualExt, $allowed)){
    // Check if the file already exists in the database
    $sql = "SELECT * FROM audios WHERE file_path = '$file_path'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        echo "Error: File already exists in the database.";
    }else{
        // Insert file path and original file name into database
        $sql = "INSERT INTO audios (file_path, audio_name, artists, user_id) VALUES ('$file_path', '$songName', '$artistName', '$user_id')";
        mysqli_query($con, $sql);

        $sql = "DELETE FROM upload_request WHERE id = $id";
         mysqli_query($con, $sql);
        header("Location: admin.php");

    }
}else{
    echo "You cannot upload files of this type.";
}
?>