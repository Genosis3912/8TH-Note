<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

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
        .mymusic{
            width: 98%;
            background-color: #2d3335;
            padding: 2%;
            
        }

        .mylist {
            width: 100%;
            backdrop-filter: blur(10px);    
            height: max-content;
            background-color: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 10px;
            text-align: center;
        }
        .mylist h1{
           color: #cde4ce;
        }
        .mytable {
  margin: 3px;
  width: 99%;
  border-collapse: collapse;
  background-color: #EBEDEF;
  font-size: 1.5em;
  font-family: sans-serif;
  min-width: 400px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  border: solid 2px black;
}

.mytable tr {
  background-color: gray;
  text-align: left;
  border: solid 1px black;
}

.mytable td {
  background-color: #D5DBDB;
  border-right: solid 2px black;
  padding: 5px;
  font-size: 0.8em;
}

.mytable th {
  background-color: #839192;
  border-right: solid 2px black;
  padding: 3px;
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

                if (!empty($user_data) && $user_data['access_level'] == 'admin') : ?>
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
                <a href="user_upload.php" class="lg"><i class="fa-solid fa-solid fa-upload"></i> Upload</a>
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
    <div class="mymusic">
        <div class="mylist">
            <h1>My Songs:</h1>
            <table class="mytable">
                <tr>
                    <th>Audio Name:</th>
                    <th>Artist:</th>
                    <th>Action:</th>
                </tr>
                <?php
                $uid = $user_data['id'];
                $sql = "SELECT id, audio_name, artists, user_id FROM audios WHERE user_id = $uid ";
                $result = mysqli_query($con, $sql);
                $audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>

                <?php foreach ($audios as $audio) : ?>
                    <?php
                    // Extract the file name from the file path
                    $songName = basename($audio['audio_name']);
                    // Remove the file extension
                    $songName = pathinfo($songName, PATHINFO_FILENAME);
                    ?>
                    <tr>

                        <td><?php echo $songName; ?></td>
                        <td><?php echo $audio['artists']; ?> </td>
                        <td style="text-align: center;">
                            <a href="audio_edit.php?id=<?php echo $audio['id']; ?>" onclick="return confirm('Are you sure you want to edit this song?')" class="button"><i class="fa-solid fa-pen-to-square"title="edit"></i></a>

                            <a href="audio_delete.php?id=<?php echo $audio['id']; ?>" onclick="return confirm('Are you sure you want to delete this song?')" class="button"><i class="fa-regular fa-trash-can"title="delete"></i></a>
                        </td>
                    </tr>


                <?php endforeach; ?>
            </table>

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