<?php
session_start();
include ("connection.php");
include ("functions.php");

$user_data = check_login($con);

if ($user_data['access_level'] != 'admin' && $user_data['access_level'] != 'owner'): {
    header("Location: Home.php");
    die;
  } ?>
<?php endif; ?>
<?php
// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, user_name, email, access_level FROM users ORDER BY user_name";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="pic\Logo.png">
    <script src="https://kit.fontawesome.com/9156a611df.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href="new1.css">
    <style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body{
          background-color: black;
        }
      
      h1{
        text-align: center;
      }
      

.adiv h1 {
 padding: 10px; 
 color: white;
  }
  /* The navigation menu links */
        
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
                    <li><a href="admin.php"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a></li>
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

<div class="adiv" style="width: 100%; height: 100vh;">

<div class="admin_links">
    <a href="#" id="users-link">Users</a><br>
    <a href="#" id="showSongs">Songs List</a><br>
    <a href="#" id="showUpload">Upload</a><br>
    <a href="#" id="showReq">Requests</a><br>
    <a href="#" id="showMessages">Messages</a><br>
</div>

<div class="admin_area">  
<div class="utable" style="display: block;">
<h1><u>List of all users:</u></h1>
<table class="user-table">

    <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Access level</th>
    <th>Delete</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
            <td><?php echo $row["user_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["access_level"]; ?></td>
            <?php
            // Add the condition here
            if ($row["access_level"] != 'admin') {
              ?>
          <td style="text-align: center;"><a href="delete_user.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this user and all their uploads?')" class="button">
            <i class="fa-regular fa-trash-can" title="delete"></i></a></td>
          <?php
            } else {
              ?>
          <td style="text-align: center;">Can't delete admin</td>
          <?php 
            }
            ?>
    </tr>

        <?php
      }
    } else {
      ?>
      <tr>
      <td colspan="6">No records</td>
      </tr>
    <?php
    }
    ?>
</table>
<a href="add_user.php" class="a_button">Add User</a>
</div>

<div class="upload" style="display: none;">
<div style="padding: 10px; display: block; float: left; width: 60%; height: 100%; background-color: #2a2727de;"><img src="uploadmusic.jpg" width="100%"></div>

<div class="upform">
<h1><u>Choose a audio file to upload:</u></h1><br>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="songname" name="songname" placeholder="Song Name"required><br>
    <input type="artist" name="artist" placeholder="Artist Name" required> <br>  
    <input type="file" name="file" id="up" required><br>
    <button type="submit" name="submit">Upload</button><br>
</form>
</div>
</div>

<div class="songlist" style="display: none;">
<h1><u>List of all songs:</u></h1>
<table class="song-table">
  <tr>
    <th>Audio Name:</th>
    <th>Artist:</th>
    <th>Action:</th>
  </tr>
<?php
$sql = "SELECT id, audio_name, artists FROM audios";
$result = mysqli_query($con, $sql);
$audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <?php foreach ($audios as $audio): ?>
          <?php
          // Extract the file name from the file path
          $songName = basename($audio['audio_name']);
          // Remove the file extension
          $songName = pathinfo($songName, PATHINFO_FILENAME);
          ?>
     <tr>

     <td><?php echo $songName; ?></td>
     <td><?php echo $audio['artists']; ?>  </td> 
     <td style="text-align: center;">
     <a href="audio_edit.php?id=<?php echo $audio['id']; ?>" onclick="return confirm('Are you sure you want to edit this song?')" class="button"><i class="fa-solid fa-pen-to-square" title="edit"></i></a>

     <a href="audio_delete.php?id=<?php echo $audio['id']; ?>" onclick="return confirm('Are you sure you want to delete this song?')" class="button"><i class="fa-regular fa-trash-can" title="delete"></i></a></td> 
      </tr>
    

    <?php endforeach; ?>
    </table>

</div>

<div class="uploadreq" style="display: none;">
  <h1><u>Upload Requests:</u></h1>
  <table class="song-table">
  <tr>
    <th>Audio Name:</th>
    <th>Artist:</th>
    
    <th>Action:</th>
  </tr>
<?php
$sql = "SELECT id, songname, file_path, artist, user_id FROM upload_request";
$result = mysqli_query($con, $sql);
$audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
    <?php foreach ($audios as $audio): ?>
          <?php
          // Extract the file name from the file path
          $songName = basename($audio['songname']);
          // Remove the file extension
          $songName = pathinfo($songName, PATHINFO_FILENAME);
          ?>
     <tr>

     <td><?php echo $songName; ?></td>
     <td><?php echo $audio['artist']; ?>  </td> 
     <td style="text-align: center;">
     <a href="upload_accept.php?songname=<?php echo $audio['songname']; ?>&artist=<?php echo $audio['artist']; ?>&file=<?php echo $audio['file_path']; ?>&id=<?php echo $audio['id']; ?>&user_id=<?php echo $audio['user_id']; ?>" onclick="return confirm('Are you sure you want to accept this request?')" class="ureq">Accept</a>

     <a href="upload_denied.php?id=<?php echo $audio['id']; ?>" onclick="return confirm('Are you sure you want to delete this song?' )" class="ureq" >Reject</a></td> 
      </tr>
    

    <?php endforeach; ?>
    </table>
</div>

<div class="messages" style="display: none;">

 <h1>List of all Messages:</h1>
 <?php
 $sql = "SELECT id, user_name, email, messages FROM request ORDER BY user_name";
$result = $conn->query($sql); ?>
  <table class="user-table">

    <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Delete</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
            <td><?php echo $row["user_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["messages"]; ?></td>
            
          <td style="text-align: center;"><a href="delete_request.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="button"><i class="fa-regular fa-trash-can" title="delete"></i></a></td>
  
    </tr>

        <?php
      }
    } else {
      ?>
      <tr>
      <td colspan="6">No requests</td>
      </tr>
    <?php
    }
    ?>
</table>

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

          document.getElementById('users-link').addEventListener('click', function() {
  document.querySelector('.utable').style.display = 'block';
  document.querySelector('.upload').style.display = 'none';
  document.querySelector('.songlist').style.display = 'none';
  document.querySelector('.uploadreq').style.display = 'none';
  document.querySelector('.messages').style.display = 'none';
});

document.getElementById('showReq').addEventListener('click', function() {
  document.querySelector('.utable').style.display = 'none';
  document.querySelector('.upload').style.display = 'none';
  document.querySelector('.songlist').style.display = 'none';
  document.querySelector('.uploadreq').style.display = 'block';
  document.querySelector('.messages').style.display = 'none';
});
document.getElementById('showSongs').addEventListener('click', function() {
  document.querySelector('.utable').style.display = 'none';
  document.querySelector('.upload').style.display = 'none';
  document.querySelector('.songlist').style.display = 'block';
  document.querySelector('.uploadreq').style.display = 'none';
  document.querySelector('.messages').style.display = 'none';
});
document.getElementById('showUpload').addEventListener('click', function() {
  document.querySelector('.utable').style.display = 'none';
  document.querySelector('.upload').style.display = 'block';
  document.querySelector('.songlist').style.display = 'none';
  document.querySelector('.uploadreq').style.display = 'none';
  document.querySelector('.messages').style.display = 'none';
});
document.getElementById('showMessages').addEventListener('click', function() {
  document.querySelector('.utable').style.display = 'none';
  document.querySelector('.upload').style.display = 'none';
  document.querySelector('.songlist').style.display = 'none';
  document.querySelector('.uploadreq').style.display = 'none';
  document.querySelector('.messages').style.display = 'block';
});

</script>
  </body>
  </html>
<?php
$conn->close();
?>
