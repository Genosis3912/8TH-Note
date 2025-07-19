<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .background {
            width: 500px;
            height: 750px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 60%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -80px;
        }

        form {
            margin-top: 6%;
            margin-bottom: 10%;
            height: max-content;
            width: 500px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form h3 {
            font-size: 25px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #0c0c0c;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        label {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
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

        button {
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
    </style>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="insert_user.php" method="post" onsubmit="return verifyForm()">
        <h1>Add User</h1>
        <label for="user_name">Name:</label>
        <input type="text" name="user_name" id="user_name" required><br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="access_level" style=" float: left;">Access Level:</label>
        <select id="access_level" type="text" name="access_level" style="margin-top: 15px; margin-left: 10px; font-size: 20px; float: left; padding: 3px;">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Add User</button>
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