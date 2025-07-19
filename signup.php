<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); //creating a hashed password
        $email = $_POST['email'];
        $access_level = "user";
        if (!empty($user_name) && !empty($password) && !is_numeric($user_name) && !is_numeric($email)) {
            // check if email already exists in the database
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($con, $query);
    
            if (mysqli_num_rows($result) > 0) {
                // email already exists
                ?>
                <script> alert("Email already exists."); </script>
                <?php
            } else {
                //save to database
                $query = "insert into users (email,user_name,password,access_level) values ('$email','$user_name','$hashed_password','$access_level')";
    
                mysqli_query($con, $query);
    
                header("Location: login.php");
                die;
            }
        } else {
            ?>
                <script> alert("Please enter valid information"); </script>
                <?php
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Signup</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #b7b6bb;
}
.background{
    width: 500px;
    height: 750px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 60%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}
form{
    margin-top: 6%;
    margin-bottom: 10%;
    height: max-content;
    width: 500px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #0c0c0c;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 25px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 20px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(14, 28, 223, 0.192);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 50px;
    width: 100%;
    background-color: #1121ac88;
    color: #010102;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.social{
  margin-top: 30px;
  display: flex;
  
}
.social div{
  background: rgb(245, 3, 3);
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(32, 96, 156, 0.534);
  color: #0d0d0efd;
  text-align: center;
  
}
.social div:hover{
  background-color: rgba(29, 21, 143, 0.39);
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}
form h3{
    font-size: 30px;
}

    </style>
    <link rel="icon" type="image/x-icon" href="pic\Logo.png">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" onsubmit="return verifyForm()">
        <a href="login.php"><i class='fas fa-angle-double-left' style='font-size:30px; margin-left: -15px;'></i></a><h3>Signin Here</h3>

        <label >Username</label>
        <input id="user_name" type="text" name="user_name" >

        <label >Email</label>
        <input id="email" type="email" name="email" >

        <label >Password</label>
        <input id="password" type="password" name="password"><br>

        <input id="button" type="submit" value="Signup">
   
    </form>
<script>
    function verifyForm() {
            // Get form data
            var userName = $("#user_name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var accessLevel = $("#access_level").val();
            // Verify form data
            if (userName == "" || email == "" || password == "") {
                alert("Please fill in all required fields.");
                return false;
            }

            // Verify email address
            var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (password.length < 12) {
                alert("Password must be at least 12 characters long.");
                return false;
            }

            var usernameRegex = /^[a-zA-Z0-9]+$/;
            if (!usernameRegex.test(userName)) {
            alert("Username should only contain letters and numbers.");
            return false;
            }

           

            // If form data is valid, submit the form
            return true;
        }
        </script>
</body>
</html>
