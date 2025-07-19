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
    <script src="B:\Coding\xampp\htdocs\8ThNote\myscript.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    <script>
        function searchSongs() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("lists");
            li = document.getElementsByClassName("player");

            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("h1")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
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
        .horizontal-container {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
  }
  .song-container {
    background-repeat: no-repeat;
    background-size: cover;
    width: 30%;
    max-width: 300px;
    margin: 10px;
    display: inline-block;
    background-image: url(player.png);
    color: #f3edec;
    border-radius: 15%;
  }
  .hrdiv{
    
    margin: 9% 3% 2%;
     width: 95%; 
     background-color: #908888cc;
     padding: 20px 10px 10px 10px;
  }
  body{
    background-image: url(backgnd.jpg);
  }
  .hrdiv h1{
    color: aliceblue;
    font-size: 2.5em;
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
<div class="hrdiv">
    <h1>Top Songs:</h1>
    <div class="horizontal-container">
        
  <?php
  $sql = "SELECT id, file_path, audio_name, play_count, artists FROM audios ORDER BY play_count DESC LIMIT 8";
  $result = mysqli_query($con, $sql);
  $audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach ($audios as $audio) {
    $songloc = basename($audio['file_path']);
    $playCount = $audio['play_count'];

    $user_id = !empty($_SESSION['id']) ? $_SESSION['id'] : 0;
                    $song_id = $audio['id'];
                    $is_favorite = false;
                    $sql = "SELECT * FROM favorite WHERE user_id = $user_id AND song_id = $song_id";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $is_favorite = true;
                    }
    ?>
    <div class="song-container">
    
                        <div class="song-info">
                            <a href="add_to_favorites.php?song_id=<?php echo $audio['id'];?>&user_id=<?php echo $user_id; ?>" style="right: 5px; color: white; font-size: 1.4em;position: absolute;top: 5px;">
                                <?php if ($is_favorite) : ?>
                                    <i class="fa-solid fa-star" style="color: yellow;" title="Favorite"></i>
                                <?php else : ?>
                                    <i class="fa-regular fa-star"></i>
                                <?php endif; ?>
                            </a>
                            <h1 id="song-name"><?php echo $audio['audio_name']; ?></h1>
                            <p>Artist: <?php echo $audio['artists']; ?></p>
                            <p>Streams: <?php echo $audio['play_count']; ?></p>

                            <audio id="haudio-<?php echo $songloc; ?>" onplay="updatePlayCount('<?php echo $songloc; ?>')" src="<?php echo $audio['file_path']; ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div id="audio-controls-<?php echo $songloc; ?>" class="audio-controls">
                                <button id="hplay-pause-button-<?php echo $songloc; ?>" class="control-button">
                                    <i id="hplay-pause-icon-<?php echo $songloc; ?>" class="fas fa-play"></i>
                                </button>
                                <input type="range" id="hprogress-bar-<?php echo $songloc; ?>" value="0">
                                <div id="hvolume-container-<?php echo $songloc; ?>">
                                    <div id="hvolume-slider-<?php echo $songloc; ?>" class="volume-slider">
                                        <input type="range" id="hvolume-control-<?php echo $songloc; ?>" min="0" max="1" step="0.1" value="1" orient="vertical">
                                    </div>
                                    <button id="hvolume-button-<?php echo $songloc; ?>" class="control-button">
                                        <i class="fas fa-volume-up"></i>
                                    </button>

                                </div>
                                <button id="hdownload-button-<?php echo $songloc; ?>" class="control-button">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>

                        </div>
                    </div>
    
    <?php
  }
  ?>
</div>
</div>

    <div class="belly">
        <div class="ttle"><strong>Song Library</strong></div>
        <div class="search-container">
            <div id="searcharea">
                <form>
                    <input type="text" id="searchInput" onkeyup="searchSongs()" placeholder="Search.." name="search">
                </form>
            </div>
        </div>
        <!-- Song lists -->
        <div id="lists">
            <div class="row1">

                <?php
                $sql = "SELECT id,file_path,audio_name, play_count, artists FROM audios";
                $result = mysqli_query($con, $sql);
                $audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $user_id = !empty($_SESSION['id']) ? $_SESSION['id'] : 0;
                ?>
                <script>
                    let currentlyPlayingAudio = null;
                </script>
                <?php foreach ($audios as $audio) : ?>
                    <?php
                    $songloc = basename($audio['file_path']);
                    $songName = basename($audio['audio_name']);    
                    $songName = pathinfo($songName, PATHINFO_FILENAME);
                    $playCount = $audio['play_count'];

                    // Check if the song is already in the user's favorites
                    $user_id = !empty($_SESSION['id']) ? $_SESSION['id'] : 0;
                    $song_id = $audio['id'];
                    $is_favorite = false;
                    $sql = "SELECT * FROM favorite WHERE user_id = $user_id AND song_id = $song_id";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $is_favorite = true;
                    }
                    ?>

                    <div class="player">
                        <div class="song-info">
                            <a href="add_to_favorites.php?song_id=<?php echo $audio['id'];?>&user_id=<?php echo $user_id; ?>" style="right: 5px; color: white; font-size: 1.4em;position: absolute;top: 5px;">
                                <?php if ($is_favorite) : ?>
                                    <i class="fa-solid fa-star" style="color: yellow;" title="Favorite"></i>
                                <?php else : ?>
                                    <i class="fa-regular fa-star"></i>
                                <?php endif; ?>
                            </a>
                            <h1 id="song-name"><?php echo $audio['audio_name']; ?></h1>
                            <p>Artist: <?php echo $audio['artists']; ?></p>
                            <p>Streams: <?php echo $audio['play_count']; ?></p>

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
                    // event for horizontal container
                    document.getElementById("hplay-pause-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                                var audio = document.getElementById("haudio-<?php echo $songloc; ?>");
                                if (audio.paused) {
                                    // Pause currently playing audio if it exists
                                    if (currentlyPlayingAudio) {
                                        currentlyPlayingAudio.pause();
                                        // Change the icon of the currently playing audio to play
                                        document.getElementById("hplay-pause-icon-" + currentlyPlayingAudio.id.replace("haudio-", "")).className = "fas fa-play";
                                    }
                                    audio.play();
                                    document.getElementById("hplay-pause-icon-<?php echo $songloc; ?>").className = "fas fa-pause";
                                    currentlyPlayingAudio = audio;
                                } else {
                                    audio.pause();
                                    document.getElementById("hplay-pause-icon-<?php echo $songloc; ?>").className = "fas fa-play";
                                    currentlyPlayingAudio = null;
                                }
                            });
                           

                    // Add event listener for progress bar
                    document.getElementById("hprogress-bar-<?php echo $songloc; ?>").addEventListener("input", function() {
                        var audio = document.getElementById("haudio-<?php echo $songloc; ?>");
                        audio.currentTime = (this.value / 100) * audio.duration;
                    });

                    // Add event listener for volume control
                    document.getElementById("hvolume-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                        var volumeSlider = document.getElementById("hvolume-slider-<?php echo $songloc; ?>");
                        volumeSlider.classList.toggle("show");
                    });

                    document.getElementById("hvolume-control-<?php echo $songloc; ?>").addEventListener("input", function() {
                        var audio = document.getElementById("haudio-<?php echo $songloc; ?>");
                        audio.volume = this.value;
                    });

                    // Add event listener for download button
                    document.getElementById("hdownload-button-<?php echo $songloc; ?>").addEventListener("click", function() {
                        var audioUrl = document.getElementById("haudio-<?php echo $songloc; ?>").src;
                        var fileName = "<?php echo $songName; ?>.mp3";
                        var a = document.createElement("a");
                        a.href = audioUrl;
                        a.download = fileName;
                        a.click();
                    });
                        });
                    </script><?php endforeach; ?>
                <script>
                    function updatePlayCount(songloc) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_play_count.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                console.log("Play count updated");
                            } else {
                                console.log("Error updating play count");
                            }
                        };
                        xhr.send("songloc=" + encodeURIComponent(songloc));
                    }
                    
                </script>

            </div>
        </div>
    </div>

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