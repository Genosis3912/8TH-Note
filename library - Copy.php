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
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    <script>

function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("closebtn").classList.add("hidden");
        }


        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("closebtn").classList.remove("hidden");
        }

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
        #audio-player {
            width: 100%;
        }

        .audio-controls {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 100%;
        }

        .control-button {
            background: white;
            border: none;
            cursor: pointer;
            font-size: 2rem;
            margin: 0 0.5rem;
            padding: 0.5rem;

        }

        #progress-bar {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            background-color: #150669;
            z-index: 1;
            color: black;
        }

        #volume-container {
            position: relative;
        }

        #volume-control {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            margin: 0;
        }
        .volume-slider {
    display: none;
    position: absolute;
    top: 0;
    right: 0;
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.volume-slider.show {
    display: block;
}

.volume-slider input[type="range"] {
    width: 20px;
    height: 100px;
    -webkit-appearance: slider-vertical;
    writing-mode: bt-lr; /* IE */
    -webkit-writing-mode: bt-lr; /* Safari */
    transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
}

.volume-slider input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    background-color: #666;
    border-radius: 50%;
    cursor: pointer;
}

.volume-slider input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background-color: #666;
    border-radius: 50%;
    cursor: pointer;
}
.player {
    position: relative; /* add this to create a new positioning context */
}
    </style>
</head>

<body>
    <nav class="topnav">
        <img src="lolo.png" id="logo" width="104px" height="80px">
        <a href="Home.php" class="mmv"><i class="fa-solid fa-house-chimney"></i>
            <div class="niv">Home</div>
        </a>
        <a href="library.php" class="mmv"><i class="fa-solid fa-music"></i>
            <div class="niv">Library</div>
        </a>
        <a href="about.php" class="mmv"><i class="fa-solid fa-circle-info"></i>
            <div class="niv">About</div>
        </a>

        <?php
        $user_data = check_login($con);
        if ($user_data['access_level'] == 'admin' || $user_data['access_level'] == 'owner') : ?>
            <a href="admin.php" class="mmv"><i class="fa-solid fa-screwdriver-wrench"></i>
                <div class="niv">Admin</div>
            </a>
        <?php endif; ?>


        <a href="#" style="float: right; color: blue;" class="logg" onclick="openNav()">
            <?php echo $user_data['user_name']; ?>
        </a>
        <div id="mySidenav" class="sidenav">
            <span class="closebtn" onclick="closeNav()">&times;</span>
            <a href="logout.php" class="loggo"><i class="fa-solid fa-right-from-bracket">log-out</i></a>
        </div>

    </nav>

    <div class="belly">
        <div class="ttle">Song Library</div>
        <div class="search-container">
            <div id="searcharea">
                <form action="/action_page.php">
                    <input type="text" id="searchInput" onkeyup="searchSongs()" placeholder="Search.." name="search">
                </form>
            </div>
        </div>


        <!-- Song lists -->
        <div id="lists">
            <div class="row1">

                <?php
                $sql = "SELECT file_path,audio_name, play_count FROM audios";
                $result = mysqli_query($con, $sql);
                $audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <?php foreach ($audios as $audio) : ?>
    <?php
    $songloc = basename($audio['file_path']);
    // Extract the file name from the file path
    $songName = basename($audio['audio_name']);
    // Remove the file extension
    $songName = pathinfo($songName, PATHINFO_FILENAME);
    $playCount = $audio['play_count'];
    ?>
    <div class="player">
        <div class="song-info">
            <h1 id="song-name-<?php echo $songloc; ?>"><?php echo $songName; ?></h1>
            <p>Play count: <?php echo $audio['play_count']; ?></p>
            
            <audio id="audio-<?php echo $songloc; ?>" src="<?php echo $audio['file_path']; ?>" type="audio/mpeg">
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
        
        // Add event listeners for audio controls
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
<?php endforeach; ?>
            </div>
        </div>
    </div>


    <script src="https://kit.fontawesome.com/26504e4a1f.js" crossorigin="anonymous"></script>
</body>

</html>