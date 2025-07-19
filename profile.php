<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>
<?php
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
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['old_password']) && !empty($_POST['old_password'])) {
    // Check the old password
    if (check_old_password($con, $user_id, $_POST['old_password'])) {
        // Update the name in the database
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $query = "UPDATE users SET user_name = '$name' WHERE id = $user_id";
        mysqli_query($con, $query);
?><script>
            alert("Name change Sucessfull.");
        </script><?php
                } else {
                    // Handle incorrect old password
                    ?><script>
            alert("Wrong password.");
        </script><?php
                }
            }

            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['old_password']) && !empty($_POST['old_password'])) {
                // Check the old password
                if (check_old_password($con, $user_id, $_POST['old_password'])) {
                    // Update the email in the database
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $query = "UPDATE users SET email = '$email' WHERE id = $user_id";
                    mysqli_query($con, $query);
                    ?><script>
            alert("Email change Sucessfull.");
        </script><?php
                } else {
                    // Handle incorrect old password
                    ?><script>
            alert("Wrong password.");
        </script><?php
                }
            }

            if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['old_password']) && !empty($_POST['old_password'])) {
                // Check the old password
                if (check_old_password($con, $user_id, $_POST['old_password'])) {
                    // Update the password in the database
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT); //creating a hashed password

                    $query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
                    mysqli_query($con, $query);
                    ?><script>
            alert("Password change Sucessfull.");
        </script><?php
                } else {
                    // Handle incorrect old password
                    ?><script>
            alert("Wrong password.");
        </script><?php
                }
            }

            if (isset($_FILES['profile_picture'])) {
                $profile_picture = $_FILES['profile_picture'];
                $profile_picture_name = $profile_picture['name'];
                $profile_picture_tmp = $profile_picture['tmp_name'];
                $profile_picture_size = $profile_picture['size'];
                $profile_picture_type = $profile_picture['type'];
                $profile_picture_error = $profile_picture['error'];

                // Check if the file is an image
                if ($profile_picture_type == 'image/jpeg' || $profile_picture_type == 'image/png') {
                    // Check if the file size is less than 2MB
                    if ($profile_picture_size < 2000000) {
                        // Upload the file to the server
                        $upload_dir = 'profilepictures/';
                        $profile_picture_path = $upload_dir . $profile_picture_name;
                        move_uploaded_file($profile_picture_tmp, $profile_picture_path);

                        // Update the user's profile picture in the database
                        $query = "UPDATE users SET profilepic = '$profile_picture_name' WHERE id = $user_id";
                        mysqli_query($con, $query);
                    ?><script>
                alert("Profile picture updated successfully!");
            </script><?php
                    } else {
                        ?><script>
                alert("File size is too large. Please upload a file less than 2MB.");
            </script><?php
                    }
                } else {
                        ?><script>
            alert("Only JPEG and PNG files are allowed.");
        </script><?php
                }
            }

            // Function to get the user data from the database
            function get_user_data($con, $user_id)
            {
                $query = "SELECT * FROM users WHERE id = $user_id";
                $result = mysqli_query($con, $query);
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
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
    <script>
        function verifyForm() {
            var userName = document.getElementById("user_name").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            var isValid = true;

            if (userName !== "") {
                // Check if username contains only letters and spaces
                if (!/^[a-zA-Z\s]+$/.test(userName)) {
                    alert("Username can only contain letters and spaces.");
                    isValid = false;
                }
            }

            if (email !== "") {
                // Check if email is in proper format
                if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                    alert("Invalid email address.");
                    isValid = false;
                }
            }

            if (password !== "") {
                // Check if password is 12 characters long and contains both letters and numbers
                if (!/^(?=.*[a-zA-Z])(?=.*[0-9]).{12,}$/.test(password)) {
                    alert("Password must be at least 12 characters long and contain both letters and numbers.");
                    isValid = false;
                }
            }

            return isValid;
        }
    </script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        #profiled {
            width: 90%;
            font-size: 25px;
            text-align: center;
            border: solid 2px black;
            padding: 10px;

        }

        #eprofile {
            width: 90%;
            border: solid 2px black;
        }

        #eprofile form {
            font-size: 25px;

        }

        .eform {
            padding: 20px 5px 5px;
            border-style: solid;
            border-width: 4px;
            display: block;
            height: 100%;
            background-color: #403c3c;
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
                <a href="myMusic.php" class="lg"><i class="fa-solid fa-music"></i> MY Music</a>
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

    <section style="color: white;">
        <div id="profiled" style="background-color: #2a2727de;">
            <div style="border-radius: 50%; width: 100px; height: 100px; position: relative; text-align: center; margin: 0 auto;">
                <form method="post" enctype="multipart/form-data" style="position: absolute; right: 1px;z-index: 1;" id="profile_picture_form">
                    <label for="profile_picture">
                        <i class="fas fa-camera" aria-hidden="true" style="font-size: 0.8em; cursor: pointer;" title="change profile picture"></i>
                        <input type="file" name="profile_picture" id="profile_picture" style="display: none;" onchange="document.getElementById('profile_picture_form').submit()">
                    </label>
                </form>
                <?php if (!empty($user_data['profilepic'])) : ?>
                    <img src="profilepictures/<?php echo $user_data['profilepic']; ?>" style="border-radius: 50%; width: 100px; height: 100px; position: relative;">
                <?php else : ?>
                    <img src="profiles.jpeg" style="border-radius: 50%; width: 100px; height: 100px; position: relative;">
                <?php endif; ?>

            </div>

            Name: <?php echo $user_data['user_name']; ?><br>
            Email: <?php echo $user_data['email']; ?><br>
            Registered on: <?php echo $user_data['date']; ?>

        </div>

        <div class="upload" id="eprofile">
            <h2 style="text-align: center; padding: 5px; color: white;">Edit Profile</h2>

            <form method="post" onsubmit="return verifyForm()" class="eform">
                <label for="name">New Name:</label>
                <input type="text" id="user_name" name="name" placeholder="New Name"><br>

                <label for="email">New Email:</label>
                <input type="email" id="email" name="email" placeholder="New Email"><br>

                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" placeholder="New Password"><br>

                <label for="old_password">Old Password:</label>
                <input type="password" id="old_password" name="old_password" placeholder="Old Password" required><br>

                <button type="submit" value="submit">Save Changes</button>
            </form>
        </div>

        <div id="eprofile" style="background-color: #2a2727de;">
            <h2 style="text-align: center; padding: 5px;">Your Favorite Songs</h2>
            <?php
            $userId = $_SESSION['id'];

            // Query the database for songs with a similar user ID
            $sql = "SELECT id, song_id FROM favorite WHERE user_id = $userId";
            $result = mysqli_query($con, $sql);
                ?>
                <script>
                    let currentlyPlayingAudio = null;
                </script>
                <?php
            // Display the song IDs
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $songId = $row['song_id'];
                    $rowid = $row["id"];
                    // Query the database for the audio details of the song
                    $audioQuery = "SELECT * FROM audios WHERE id = $songId";
                    $audioResult = mysqli_query($con, $audioQuery);

                    if (mysqli_num_rows($audioResult) > 0) {
                        $audioRow = mysqli_fetch_assoc($audioResult);
            ?>
                        <div class="player" style="width: 23%;">
                            <div class="song-info">
                                <a href="delete_favorite.php?id=<?php echo $rowid ?>" onclick="return confirm('Are you sure you want to unfavorite?')" style="padding-left: 80%; color: white; font-size: 22px;">
                                    <i class="fa-solid fa-trash-can"></i></a>
                                </a>
                                <h1 id="song-name"><?php echo $audioRow['audio_name'] ?></h1>
                                <p>Artist: <?php echo $audioRow['artists']; ?></p>
                                <p>Streams: <?php echo $audioRow['play_count']; ?></p>

                                <audio id="audio-<?php echo $songloc; ?>" onplay="updatePlayCount('<?php echo $songloc; ?>')" src="<?php echo $audio['file_path']; ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <div id="audio-controls-<?php echo $songloc; ?>" class="audio-controls">
                                    <button id="play-pause-button-<?php echo $songloc; ?>" class="control-button">
                                        <i id="play-pause-icon-<?php echo $songloc; ?>" class="fas fa-play"></i>
                                    </button>
                                    <input type="range" id="progress-bar-<?php echo $songloc; ?>" value="0">
                                    <div id="volume-container-<?php echo $songloc; ?>">
                                        <div id="volume-slider-<?php echo $songloc; ?>" class="volume-slider">
                                            <input type="range" id="volume-control-<?php echo $songloc; ?>" min="0" max="1" step="0.1" value="1" orient="vertical">
                                        </div>
                                        <button id="volume-button-<?php echo $songloc; ?>" class="control-button">
                                            <i class="fas fa-volume-up"></i>
                                        </button>

                                    </div>
                                    <button id="download-button-<?php echo $songloc; ?>" class="control-button">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("play-pause-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                                    var audio = document.getElementById("audio-<?php echo $songloc; ?>");
                                    if (audio.paused) {
                                        // Pause currently playing audio if it exists
                                        if (currentlyPlayingAudio) {
                                            currentlyPlayingAudio.pause();
                                            // Change the icon of the currently playing audio to play
                                            document.getElementById("play-pause-icon-" + currentlyPlayingAudio.id.replace("audio-", "")).className = "fas fa-play";
                                        }
                                        audio.play();
                                        document.getElementById("play-pause-icon-<?php echo $songloc; ?>").className = "fas fa-pause";
                                        currentlyPlayingAudio = audio;
                                    } else {
                                        audio.pause();
                                        document.getElementById("play-pause-icon-<?php echo $songloc; ?>").className = "fas fa-play";
                                        currentlyPlayingAudio = null;
                                    }
                                });
                            });
                            document.getElementById("play-pause-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                                var audio = document.getElementById("audio-<?php echo $songloc; ?>");
                                if (audio.paused) {
                                    audio.play();
                                    document.getElementById("play-pause-icon-<?php echo $songloc; ?>").className = "fas fa-pause";
                                } else {
                                    audio.pause();
                                    document.getElementById("play-pause-icon-<?php echo $songloc; ?>").className = "fas fa-play";
                                }
                            });

                            // Add event listener for progress bar
                            document.getElementById("progress-bar-<?php echo $songloc; ?>").addEventListener("input", function() {
                                var audio = document.getElementById("audio-<?php echo $songloc; ?>");
                                audio.currentTime = (this.value / 100) * audio.duration;
                            });

                            // Add event listener for volume control
                            document.getElementById("volume-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                                var volumeSlider = document.getElementById("volume-slider-<?php echo $songloc; ?>");
                                volumeSlider.classList.toggle("show");
                            });

                            document.getElementById("volume-control-<?php echo $songloc; ?>").addEventListener("input", function() {
                                var audio = document.getElementById("audio-<?php echo $songloc; ?>");
                                audio.volume = this.value;
                            });

                            // Add event listener for download button
                            document.getElementById("download-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                                var audioUrl = document.getElementById("audio-<?php echo $songloc; ?>").src;
                                var fileName = "<?php echo $songName; ?>.mp3";
                                var a = document.createElement("a");
                                a.href = audioUrl;
                                a.download = fileName;
                                a.click();
                            });
                        </script>
            <?php
                    } else {
                        echo "No audio found for song ID $songId<br>";
                    }
                }
            } else {
                echo "No songs found for user ID $userId";
            }

            ?>
        </div>

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