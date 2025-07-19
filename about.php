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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>8thnote Library</title>
        
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

       

        /* The navigation menu links */
        
        body .econtainer {
            font-family: 'Muli', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }
        .econtainer {
            display: flex;
            float: right;
            width: 90vw;
        }
        
        .panel {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            height: 80vh;
            border-radius: 50px;
            color: #fff;
            cursor: pointer;
            flex: 0.5;
            margin: 10px;
            position: relative;
            transition: flex 600ms ease-in;
            background-color: #1e1e1e;
        }


        .panel h3 {
            font-size: 24px;
            position: absolute;
            bottom: 20px;
            left: 20px;
            margin: 0;
            opacity: 0;
        }
        
        .panel.active {
            flex: 5;
        }

        .panel.active h3 {
            opacity: 1;
            transition: opacity 0.1s ease-in 0.2s;
        }
        @media (max-width: 480px) {
            .econtainer {
                width: 100vw;
            }

            .panel:nth-of-type(4),
            .panel:nth-of-type(5) {
                display: none;
            }
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

    
    <section>

        <div class="econtainer">
            <div class="panel active" style="background-image: url('1.jpg'); filter:blur(2px);
                -webkit-filter: blur(0px);">
                <h3> </h3>
            </div>
            <div class="panel" style="background-image: url('2.jpg')">
                <h3></h3>
            </div>
            <div class="panel" style="background-image: url('3.jpg')">
                <h3></h3>
            </div>
            <div class="panel" style="background-image: url('4.jpg')">
                <h3></h3>
            </div>
            <div class="panel" style="background-image: url('5.jpg')">
                <h3></h3>
            </div>
        </div>
 </section>

    <script> 
    const panels = document.querySelectorAll('.panel')

panels.forEach(panel => {
    panel.addEventListener('click', () => {
        removeActiveClasses()
        panel.classList.add('active')
    })
})

function removeActiveClasses() {
    panels.forEach(panel => {
        panel.classList.remove('active')
    })
}
    function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("closebtn").classList.add("hidden");  
        }
          
          
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("closebtn").classList.remove("hidden");
          }</script>
    
</body>
</html>