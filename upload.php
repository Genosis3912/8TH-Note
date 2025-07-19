<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if(isset($_POST['submit'])){
    $file = $_FILES['file'];

    // File properties
    $songName = $_POST['songname'];
    $artistName = $_POST['artist'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Check if file is an audio file
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('mp3', 'wav', 'ogg', 'm4a');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            // Upload file
            $fileNameNew = $fileName. '_'. uniqid('', true). ".". $fileActualExt;
            $fileDestination = 'uploads/'. $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            // Insert file path and original file name into database
            $sql = "INSERT INTO audios (file_path, audio_name, artists) VALUES ('$fileDestination', '$songName', '$artistName')";
            mysqli_query($con, $sql);
            header("Location: admin.php");
        }else{
            echo "There was an error uploading your file.";
        }
    }else{
        echo "You cannot upload files of this type.";
    }
}
?>
 