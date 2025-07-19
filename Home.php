<?php
session_start();

include ("connection.php");
include ("functions.php");

$user_data = check_login($con);

function get_songs_by_play_count() {
    global $con;

    $query = "SELECT * FROM audios ORDER BY play_count DESC LIMIT 6";
    $result = mysqli_query($con, $query);

    $songs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $songs[] = $row;
    }

    return $songs;
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>8th Note</title>
    <link rel="stylesheet" href="new1.css">
    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        .card h3{
            padding: 15px 10px 2px;
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
                <a style="float: right; color: blue; cursor: pointer;" class="all-links" onclick="openNav()"><i class="fa-solid fa-user"></i>
                    <?php echo $user_data['user_name']; ?>
                </a> 
            </ul>
            <div id="mySidenav" class="sidenav">
                <a class="closebtn" onclick="closeNav()">&times;</a>
                <a href="profile.php" class="lg"><i class="fa-solid fa-solid fa-user"></i> Profile</a>
                <a href="myMusic.php" class="lg"><i class="fa-solid fa-music"></i> MY Music</a>
                <a href="user_upload.php" class="lg"><i class="fa-solid fa-solid fa-upload"></i> Upload</a>
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

    <section class="homepage" id="home">
        <div class="content">
            <div class="text">
                <h1>Welcome To
                    8th Note</h1>
                <p>
                    Discover, stream, and share a constantly expanding mix of music from emerging <br>and major artists
                    around the world.</p>
            </div>
            <a href="#services">Our Services</a>
        </div>
    </section>

    <section class="services" id="services">
        <h2>Our Services</h2>
        <p>Explore our wide range of services.</p>
        <ul class="cards">
            <li class="card">
                <img src="play.png" alt="img">
                <h3>Music Streaming</h3>
                <p>Listen to millions of songs and playlists on-demand.</p>
            </li>
            <li class="card">
                <img src="playlist.png" alt="img">
                <h3>Curated Playlists</h3>
                <p>Enjoy handpicked playlists for every mood and occasion.</p>
            </li>
            <li class="card">
                <img src="search.png" alt="img">
                <h3>Music Discovery</h3>
                <p>Discover new artists and songs based on your preferences.</p>
            </li>
            <li class="card">
                <img src="share.png" alt="img">
                <h3>Social Features</h3>
                <p>Share your favorite songs and playlists with friends.</p>
            </li>
            <li class="card">
                <img src="download.png" alt="img">
                <h3>Offline Listening</h3>
                <p>Download songs and playlists for offline listening.</p>
            </li>
            <li class="card">
                <img src="haudio.png" alt="img">
                <h3>High-Quality Audio</h3>
                <p>Experience music in high-quality audio formats.</p>
            </li>
        </ul>
    </section>

    <section class="portfolio" id="portfolio">
    <h2>Top Musics</h2>
    <p>Take a look at some of our best creations.</p>
    <ul class="cards">
        <?php
        $songs = get_songs_by_play_count();
        foreach ($songs as $song) {
            echo '<li class="card">';
            echo '<h3>'. $song['audio_name']. '</h3>';
            echo '<p>'. $song['artists']. '</p>';
            echo '<p> Streams:'. $song['play_count']. '</p><br>';
            echo '<audio src="'. $song['file_path']. '" controls></audio>';
            echo '</li>';
        }
       ?>
    </ul>
</section>

    <hr style="color: rgba(218, 218, 226, 0.84)" size="15px" style=" margin: 0;">
    <div class="slideshow-container">

        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <div class="spic"><img src="pic/1.png"></div>

        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <div class="spic"><img src="pic/2.png"></div>

        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <div class="spic"><img src="pic/3.png"></div>

        </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
        <div class="bdot" style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>


    <section class="about" id="about">
        <h2>About Us</h2>
        <p>Discover our story in providing Music services.</p>
        <div class="row company-info">
            <h3>Our Story</h3>
            <p>8th Note is a Website that recognises music around you. It is the best way to discover, explore and share
                the music you love. 8th Note intends to connect more than 1 billion people. It's an amazing site,
                available now on the internet. And we're always looking for new and innovative ways to delight our
                users.</p>
        </div>
        <div class="row mission-vision">
            <h3>Our Mission</h3>
            <p>Our mission is to help people recognise
                and engage with the world around them</p>
            <h3>Our Vision</h3>
            <p>Our vision is to become the go-to destination for Music enthusiasts, known for our extensive selection of
                premium Music and exceptional customer service. We aspire to inspire and enable people to embrace their
                dream of music and create the best music.</p>
        </div>
        <div class="row team">
            <h3>Our Team</h3>
            <ul>
            <li>Akhilesh - Project Manager</li>
                <li>Ankur Khadka- Student</li>
                <li>Rakshit Gautam - Student</li>
            </ul>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2>Book a Session</h2>
        <p>Reach out to us for any inquiries or feedback.</p>
        <div class="row">
            <div class="col information">
                <div class="contact-details">
                    <p><i class="fas fa-map-marker-alt"></i> Kathmandu, Satungal </p>
                    <p><i class="fas fa-envelope"></i> info@8thNote.com</p>
                    <p><i class="fas fa-phone"></i> 9899999999</p>
                    <p><i class="fas fa-globe"></i> www.8thNote.com</p>
                </div>
            </div>
            <div class="col form" method="post">
    <form action="submit.php" method="post">
        <input type="text" placeholder="Name*" name="user_name" required>
        <input type="email" placeholder="Email*" name="email" required>
        <textarea placeholder="Message*" name="message" required></textarea>
        <button id="submit" type="submit">Send Message</button>
    </form>
</div>
        </div>
    </section>

    <footer>
        <div>
            <span>Copyright © 2023 All Rights Reserved</span>
            <span class="link">
                
            </span>
        </div>
    </footer>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }

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