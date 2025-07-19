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
    <title>About</title>
    <link rel="icon" type="image/x-icon" href="pic\Logo.png">
    <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    

    <style>
        
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
            background-color: black;
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
            <h2 class="logo"><a href="#">8th Note</a></h2>
            <input type="checkbox" id="menu-toggler">
            <label for="menu-toggler" id="hamburger-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
                </svg>
            </label>
            <ul class="all-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="library.php">Library</a></li>
                <li><a href="about.php">About Us</a></li>
                <?php
                $user_data = check_login($con);
                if ($user_data['access_level'] == 'admin' || $user_data['access_level'] == 'owner'): ?>
                <li><a href="admin.php">admin</a></li>
                <?php endif; ?>

                <a href="#" style="float: right; color: blue;" class="all-links" onclick="openNav()">
                    <?php echo $user_data['user_name']; ?>
                </a>
            </ul>
            <div id="mySidenav" class="sidenav">
                <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="logout.php" class="all-links"><i class="fa-solid fa-right-from-bracket"></i>log-out</a>
              </div>
        </nav>
    </header>

<div class="belly">
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
    </div>
    <footer>
        <div class="follow">
            <h3>Follow Us :</h3>
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-snapchat-ghost"></a>
        </div>
    </footer>
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
          }
    </script>
</body>

</html>