<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
    
        // File properties
        $songName = $_POST['songname'];
        $artistName = $_POST['artist'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $user_id = $user_data['id'];
        // Check if file is an audio file
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = array('mp3', 'wav', 'ogg', 'm4a');
    
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                // Upload file
                $fileNameNew = $fileName . '_' . uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                // Insert file path and original file name into database
                $sql = "INSERT INTO upload_request (file_path, songname, artist, user_id) VALUES ('$fileDestination', '$songName', '$artistName', '$user_id')";
                mysqli_query($con, $sql);
    
    
    ?> <script>
                    alert("Upload request sucessful.");
                </script><?php
                        } else {
                            ?> <script>
                    alert("Upload request Failed.");
                </script>
    
            <?php
                        }
                    } else {
            ?> <script>
                alert("Can't upload these types of files.");
            </script>
            
    <?php
                    }
                }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>8thnote Library</title>
        
        <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
        <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
     <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        /* The navigation menu links */
       
    </style>
        </head>
<body>
<header>
        <nav class="navbar">
        <h2 class="logo"><a href="#"><img src="lolo.png" style="position: absolute; z-index: -1; margin: 0; width: 90px; height: 60px;">8th Note</a></h2>

            <input type="checkbox" id="menu-toggler">
            <label for="menu-toggler" id="hamburger-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
                </svg>
            </label>
            <ul class="all-links">
                <li><a href="Home.php"><i class="fa-solid fa-house-chimney"></i> Home</a></li>
                <li><a href="library.php"><i class="fa-solid fa-music"></i> Library</a></li>
                <li><a href="about.php"><i class="fa-solid fa-circle-info"></i> About Us</a></li>
                <?php
                
                if (!empty($user_data) && $user_data['access_level'] == 'admin'): ?>
                    <li><a href="admin.php"><i class="fa-solid fa-screwdriver-wrench"></i> admin</a></li>
                <?php endif; ?>

                <?php
                $user_data = check_login($con);
                if (!empty($user_data)) {
                ?>
                <a href="#" style="float: right; color: blue;" class="all-links" onclick="openNav()"><i class="fa-solid fa-user"></i>
                    <?php echo $user_data['user_name']; ?>
                </a> 
            </ul>
            <div id="mySidenav" class="sidenav">
                <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="profile.php" class="lg"><i class="fa-solid fa-solid fa-user"></i> Profile</a>
                <a href="myMusic.php" class="lg"><i class="fa-solid fa-music"></i> MY Music</a>
                <a href="logout.php" class="lg"><i class="fa-solid fa-right-from-bracket"></i>log-out</a>
              </div>
              <?php } else{
                ?>
                <li><a href="login.php"><i class="fa-solid fa-screwdriver-wrench"></i> login/signup</a></li>
                <?php
              }
            ?>
        </nav>
    </header>

<section>
<div class="upload">
<div style="padding: 10px; display: block; float: left; width: 60%; height: 90%; background-color: #2a2727de;"><img src="uploadmusic.jpg" width="80%"></div>

<div class="upform">
<h1 style="color: white;"><u>Choose a audio file to upload:</u></h1><br>
<form method="post" enctype="multipart/form-data">
<label>Song Name:</label>
    <input type="songname" name="songname" placeholder="Song Name"required><br>
    <label>Artist:</label>
    <input type="artist" name="artist" placeholder="Artist Name" required> <br>  
    <input type="file" name="file" id="up" required><br>
    <button type="submit" name="submit" style="cursor: pointer;">Upload</button><br>
</form>
</div>
</div>
</section>
    <script> 
    function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("closebtn").classList.add("hidden");  
        }
          
          
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("closebtn").classList.remove("hidden");
          }
          
   
          </script>
          <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/26504e4a1f.js" crossorigin="anonymous"></script>
</body>
</html>