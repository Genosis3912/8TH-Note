<?php
session_start();

include ("connection.php");
include ("functions.php");

$user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="pic\Logo.png">
    <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
    
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    <style>
        .vid-container {
            width: 100%;
            height: 100%;
            margin: 0 auto;
        }

        .vid-container video {
            object-fit: fill;
            width: 100%;
            height: 80vh;
        }

        .sidenav {
            float: right;
  height: 15%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1; /* Stay on top */
  top: 11px; /* Stay at the top */
  right: 0;
  background-color: #545455; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */

}

/* The navigation menu links */
.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover {
  color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
  position: absolute;
  top: 5px;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}


    </style>
</head>

<body background-color="blue">
    
    <nav class="topnav">
        <img src="lolo.png" id="logo" width="104px" height="80px">
        <a href="Home.php" class="mmv"><i class="fa-solid fa-house-chimney"></i><div class="niv">Home</div></a>
        <a href="library.php" class="mmv"><i class="fa-solid fa-music"></i><div class="niv">Library</div></a>
        <a href="about.php" class="mmv"><i class="fa-solid fa-circle-info"></i><div class="niv">About</div></a>

        <?php
        $user_data = check_login($con);
        if ($user_data['access_level'] == 'admin' || $user_data['access_level'] == 'owner'): ?>
            <a href="admin.php" class="mmv"><i class="fa-solid fa-screwdriver-wrench"></i><div class="niv">Admin</div></a>
<?php endif; ?>
        
    
    <a href="#" style="float: right; color: blue;" class="logg" onclick="openNav()">
        <?php echo $user_data['user_name']; ?>
    </a>
    <div id="mySidenav" class="sidenav">
        <span class="closebtn" onclick="closeNav()">&times;</span>
        <a href="logout.php" class="loggo"><i class="fa-solid fa-right-from-bracket">log-out</i></a>
      </div>
    
    </nav>

    <div class="vid-container">
        <video autoplay>
            <source src="production_id_4380097_1080p.mp4" type="video/mp4">

            Your browser does not support the video tag.
        </video>
    </div>


    <div class="welcm">
        <div class="bg-text">Welcome To <br> 8th Note</div>
    </div>
    <div class="cp-header cmp-header">
        <h1>"Our mission is to help people recognise <br>and engage with the world around them"</h1>
        <p>8th Note is a Website that recognises music around you. It is the best way to discover, explore and share
            the music you love. 8th Note intends to connect more than
            <strong>1 billion</strong> people.
            It's an amazing site, available now on the internet. And
            we're always looking for new and innovative ways to delight our users.
        </p>
    </div>
    <hr color="black" size="15px" style=" margin: 0;">
    <!-- Slideshow container -->
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
    <div style="text-align: center;">
        <span>
            <h1>Our Services</h1>
        </span>
    </div>
    <!--Job to be done -->
    <div class="Serv">
        <div class="S-content">
            <center> <img width="80" height="80"
                    src="https://classxpresentation.com/wp-content/uploads/2020/12/M-400x400.png">
                <br>
                <b>Listen Music </b>
                <br>
                Listen to high quality<br> music with best online <br>audio streaming
                platform.
            </center>
        </div>
        <div class="S-content">
            <center> <img width="80" height="80" src="https://classxpresentation.com/wp-content/uploads/2020/12/V.png">
                <br><b>Record Music</b>
                <div>
                    Easily record and share <br>your favorite songs.</div>
            </center>
        </div>
        <div class="S-content">
            <center> <img width="80" height="80"
                    src="https://classxpresentation.com/wp-content/uploads/2020/12/recording.png">
                <br><b>Buy and Sell</b><br>

            </center>
        </div>
    </div>
    <footer>
        <div class="wii widget1"><b>Site Overview</b><br>
            Discover<br>
            Articles<br>
            New Release<br>
        </div>
        <div class="wii widget2">
            <b>Follow Us :</b><br>
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a><br>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-snapchat-ghost"></a>
        </div>
        <div class="wii widget3"><b>About Us</b><br>
            What is 8thNote?<br>
            Privacy Policy<br>
            Terms and Services<br>
            Copyright Policy
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
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("closebtn").classList.add("hidden");  
        }
          
          
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("closebtn").classList.remove("hidden");
          }
    </script>
</body>

</html>