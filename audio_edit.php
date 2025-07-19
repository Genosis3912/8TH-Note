<?php
session_start();
include("connection.php");
include("functions.php");
// Get the id from the URL parameter
$id = $_GET['id'];

// Query the database to retrieve the audio information
$sql = "SELECT id, audio_name, artists FROM audios WHERE id = '$id'";
$result = mysqli_query($con, $sql);
$audio = mysqli_fetch_assoc($result);

// Display the edit form
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

        #profiled{
            width: 90%;
            font-size: 25px;
            text-align: center;
            border: solid 2px black;
            padding: 10px;
           
        }
        #eprofile{
            width: 90%;
            font-size: 25px;
            border: solid 2px black;
        }
        #eprofile form{
            font-size: 25px;
            padding: 2% 30%;
        }

      
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
                    <a href="myMusic.php" class="lg"><i class="fa-solid fa-music"></i> MY Music</a>
                    <a href="logout.php" class="lg"><i class="fa-solid fa-right-from-bracket"></i>log-out</a>
                  </div>
              <?php } else {
                    ?>
                    <li><a href="login.php"><i class="fa-solid fa-screwdriver-wrench"></i> login/signup</a></li>
                    <?php
                }
                ?>
        </nav>
    </header>
    <section>
        <div id="profiled">
        <img src="musicprof.jpeg" style="border-radius: 50%;"><br>
<form action="audio_edit.php" method="post">
    <label for="song_name">Song Name:</label>
    <input type="text" id="song_name" name="song_name" value="<?php echo $audio['audio_name'];?>">
<br>
    <label for="artists">Artist Name:</label>
    <input type="text" id="artists" name="artists" value="<?php echo $audio['artists'];?>">

    <input type="hidden" name="id" value="<?php echo $id;?>"><br>
    <input type="submit" value="Save Changes">
</form>
            </div>
            <?php
// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $song_name = $_POST['song_name'];
    $artist_name = $_POST['artists'];

    // Update the database with the new values
    $sql = "UPDATE audios SET audio_name = '$song_name', artists = '$artist_name' WHERE id = '$id'";
    mysqli_query($con, $sql);

    // Redirect back to the original page
    header('Location: admin.php');
    exit;
}
?>
</section>
<script>
    function openNav() {
            document.getElementById("mySidenav").style.width = "230px";
            document.getElementById("closebtn").classList.add("hidden");  
        }
          
          
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("closebtn").classList.remove("hidden");
          }
    </script>
</body>

</html>
