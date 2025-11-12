<?php
session_start();
include('config.php');
include("LoggedIn.php");

if (isset($_POST['edt_Prof'])) {
  header("location:EditProfile.php");
}

if (isset($_POST['LogOut'])) {
  // $_SESSION['UID'] ="";
  
  // $_SESSION['Email'] = "";
  // $_SESSION['Profile_picture'] = "";
  // $_SESSION['create_at'] = "";
  // $_SESSION['UserName'] = "";
  // $_SESSION['Password'] = "";
  // $_SESSION['bio'] = "";
  // $_SESSION['Website'] = "";

  session_destroy();
  session_unset();
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
 
  <?php include("LinkConfig.php"); ?>
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      overflow-x: hidden;
      
    }

    /* Header */
    .app-header {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.4);
      position: sticky;
      top: 0;
      z-index: 100;

    }

    .logo {
      font-size: 24px;
      font-weight: 700;
      color: #333;
    }

    #logo {
      height: 70px;
      width: 70px;
      border-radius: 50%;
    }

    #ConnectUs {
      padding-right: 30px;
    }

    .chat-btn {
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.5);
      color: #333;
      font-size: 22px;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.25s ease-in-out;
    }

    .chat-btn:hover {
      background: rgba(245, 96, 64, 0.8);
      color: #fff;
      transform: scale(1.05);
    }

    /* Profile Layout */
    .profile-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 60px 8%;
      gap: 50px;
      flex-wrap: wrap;
    }

    /* Profile Picture - Bigger */
    .profile-pic {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      border: 4px solid #f56040;
      background: url('<?php echo $_SESSION["Profile_picture"]; ?>') no-repeat center/cover;
      flex-shrink: 0;
    }

    /* Middle Section - Larger Font and Buttons */
    .profile-info {
      flex: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      transform: scale(1.1);
    }

    .username {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .connections {
      font-size: 18px;
      color: #555;
      margin-bottom: 25px;
      cursor: pointer;
    }

    .connections span {
      font-weight: bold;
      color: #000;
      cursor: pointer;
    }

    .button-row {
      display: flex;
      gap: 12px;
      justify-content: center;
    }

    .edit-btn,
    .share-btn {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      border: 2px solid #fff;
      color: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .edit-btn:hover,
    .share-btn:hover {
      transform: scale(1.05);
    }

    /* Bio - Slightly Larger */
    .bio-section {
      flex: 1.3;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px);
      border-radius: 18px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transform: scale(1.05);
      max-height: 250px;
    }

    .bio-title {
      font-weight: 700;
      margin-bottom: 10px;
      font-size: 18px;
    }

    .bio {
      font-size: 15px;
      color: #555;
      line-height: 1.6;
    }

    /* Posts Section - Smaller Grid */
    .posts-section {
      flex: 1;
      padding: 30px 8%;
      display: flex;
      justify-content: center;
      flex-direction: column;
    }

    .posts-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 25px;
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
    }

    .post {
      position: relative;
      border: 2px solid rgba(0, 0, 0, 0.1);
      /* Light gray border */
      border-radius: 15px;
      /* Smooth rounded corners */
      overflow: hidden;
      background: #fff;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      cursor: Pointer;
    }

    /* Smaller Images */
    .post img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
      border-radius: 10px;
    }

    .post:hover img {
      transform: scale(1.1);
      filter: brightness(60%);
    }

    .post-overlay {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      color: #fff;
      text-align: center;
      font-size: 15px;
      font-weight: 500;
    }

    .post:hover .post-overlay {
      opacity: 1;
    }

    .post-icons {
      display: flex;
      gap: 18px;
      font-size: 20px;
      margin-bottom: 8px;
    }

    .post-counts {
      font-size: 13px;
      color: #fff;
    }

    /* Bottom Nav */
    .bottom-nav {
      position: sticky;
      bottom: 0;
      left: 0;
      right: 0;
      height: 70px;
      display: flex;
      justify-content: space-around;
      align-items: center;
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      border-top: 1px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.1);
      z-index: 100;
      border-radius: 18px 18px 0 0;
    }

    .bottom-nav a {
      text-decoration: none;
      color: #333;
      font-size: 22px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: all 0.3s ease;
    }

    .bottom-nav a span {
      font-size: 11px;
    }

    .bottom-nav a:hover,
    .bottom-nav a.active {
      color: #f56040;
      transform: translateY(-3px);
    }



#frndlist {
background-color: white;
      height: 100vh;
      width: 40%;
      position: fixed;
      top: 100px;
      right: 0px;
      display: none;
       backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      border-top: 1px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.1);
      z-index: 102;
       animation: introlst 0.5s ease-in-out;
}

  .scroll {
       height: 100vh;
      width:100%;
      display: flex;
      align-items: start;
      justify-content: start;
      flex-direction: column;
      gap: 5px;
      padding-left: 5px;
     
      overflow-y:auto;
     
    }

    .scroll::-webkit-scrollbar {
        display: none;
    }

    .frnd {
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .frndimg {
      height: 4rem;
      width: 4rem;
      margin: 2px;
      border-radius: 25px;
    }

    .frndnm {
      line-height: 30px;
      margin-left: 10px;
    }

    #frndlist hr {
      background-color: lightgray;
      height: 1px;
      width: 100%;
    }


    .blurzone {
      display: none;
      background: rgba(0, 0, 0, 0.8);
      filter: blur(20);
      height: 100vh;
      width: 60%;
      position: fixed;
      top: 100px;
      left: 0px;
      z-index: 101;
      animation: introblr 0.5s ease-in-out;
    }

    #frndcnt {
      font-size: 18px;
      color: #555;
      margin-bottom: 25px;
      cursor: pointer;
      font-weight: normal;
    }

   


    @keyframes introblr {

      from {
        width: 100%;
        /* top:100px;
  left:60%; */
      }

      to {
        width: 60%;
        /* top:100px;
  left:0px; */
      }

    }

    @keyframes introlst {

      from {

        width: 0%;
      }

      to {
        width: 40%;
      }

    }


    #log {
      margin-right: 30px;
      border-radius: 100px;
      background: linear-gradient(135deg, #ffffffff 0%, crimson 50%, crimson 60%, #ffffffff 100%);
    }


    @media (max-width: 1000px) {
      .profile-top {
        padding: 40px 5%;
        gap: 30px;
      }

      .profile-pic {
        width: 160px;
        height: 160px;
      }

      .posts-grid img {
        height: 200px;
      }
    }

    @media (max-width: 700px) {
      .profile-top {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .bio-section {
        width: 90%;
      }

      .posts-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .posts-grid img {
        height: 180px;
      }

      #frndlist {
        width: 100%;
      }

      .blurzone {
        display: none;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="app-header">
    <img src="./Assets/logo.jpeg" id="logo">
    <h1 class="logo">Your Profile</h1>
    <form method="post"><button class="edit-btn" id="log" name="LogOut" type="submit"><i
          class="fa-solid fa-power-off"></i></button></form>
  </header>

  <!-- Profile Top Section -->
  <section class="profile-top">
    <div class="profile-pic"></div>


    <div class="profile-info">
      <div class="username">@<?php echo $_SESSION['UserName']; ?></div>
      <div class="connections"><span><?php

      $sql = "SELECT COUNT(*) AS postCount FROM posts WHERE UserId=" . $_SESSION['UID'] . ";";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['postCount'];

      ?></span> Posts | <span onclick="FriendFun()"><?php

      $sql = "SELECT COUNT(*) AS friendCount FROM friends WHERE UserId=" . $_SESSION['UID'] . " OR FriendId=" . $_SESSION['UID'] . ";";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['friendCount'];

      ?></span onclick="FriendFun()"> <span id="frndcnt" onclick="FriendFun()"> Friends</span></div>
      <div class="button-row">
        <form method="post"><button class="edit-btn" name="edt_Prof" type="submit">Edit Profile</button></form>
        <button class="share-btn" id="shareProfileButton">Share Profile</button>
      </div>
    </div>

    <div class="bio-section">
      <div class="bio-title">About Me</div>
      <div class="bio">
        <?php echo $_SESSION['bio']; ?>
        <br>
        <?php
        if (isset($_SESSION['Website'])) {
          if (str_contains($_SESSION['Website'], "https://") || str_contains($_SESSION['Website'], "http://")) {
            echo "<a href='" . $_SESSION['Website'] . "' target='_blank'><i class='fa-solid fa-link'></i></a>";

          } else {
            echo "<a href='https://" . $_SESSION['Website'] . "' target='_blank'><i class='fa-solid fa-link'></i></a>";
          }
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Posts Section -->
  <section class="posts-section">
    <div class="posts-grid">
      <!-- Post -->

      <?php


      $sql = "SELECT path,caption,created_at,PostId from posts where UserId=" . $_SESSION['UID'] . " ORDER BY created_at DESC;";
      $res = $conn->query($sql);
      if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
          $postId = (int) $row['PostId'];
          $path = htmlspecialchars($row['path'], ENT_QUOTES);
          $caption = htmlspecialchars($row['caption'], ENT_QUOTES);
          $uid = (int) $_SESSION['UID'];
          echo '<div class="post" onclick="postpg(' . $postId . ',`' . $path . '`,`' . $caption . '`,'. $uid . ')">
            <img src="' . $row["path"] . '">
            <div class="post-overlay">
              <div class="post-icons">' . $row["caption"] . '</div>
              <div class="post-counts">1.2K Likes • 80 Comments</div>
            </div>
          </div>';


        }
      } else {
        echo "Click on + to Uploads Photos";
      }


      ?>

      <div class="blurzone" onclick="FriendFunRmv()"></div>
      <div id="frndlist">

        <div style="height:20px;width:20px;position:fixed;right:10px;text-align:center;cursor:pointer;margin:20px;background-color:white;border-radius:50%;line-height:20px;" onclick="FriendFunRmv()">X</div>

        <div class="scroll">
        
        <?php
        $sql = "SELECT 
    u.UserId,
    u.UserName,
    u.Profile_picture
FROM users u
WHERE u.UserId IN ( SELECT CASE WHEN f.UserId = " . $_SESSION['UID'] . " THEN f.FriendId ELSE f.UserId END AS Friend FROM friends f WHERE f.UserId = " . $_SESSION['UID'] . " OR f.FriendId = " . $_SESSION['UID'] . " ) ORDER BY created_at DESC;";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {

          while ($row = $res->fetch_assoc()) {

            echo " 
        <div>
        <div class='frnd' onclick=newpg('" . $row['UserName'] . "')><img class='frndimg' src='" . $row['Profile_picture'] . "' alt=''>
        <p class='frndnm'>" . $row['UserName'] . "</p>
        </div>
        </div>
        <hr>
    
    ";
          }
        }


        ?>
        </div>
      </div>



    </div>
  </section>

  <!-- Bottom Navigation -->
  <!-- <div class="bottom-nav">
    <a href="feed.html">🏠<span>Home</span></a>
    <a href="search.html">🔍<span>Search</span></a>
    <a href="post.html">➕<span>Post</span></a>
    <a href="notifications.html">❤️<span>Alerts</span></a>
    <a href="#" class="active">👤<span>Profile</span></a>
  </div> -->
  <?php include('Navbar.php'); ?>


  <script>
    function FriendFun() {
      document.querySelector("#frndlist").style.display = "flex";
      document.querySelector(".blurzone").style.display = "block";
      // document.querySelector("#frndlist").style.overflowY = "auto";
      // document.querySelector("body").style.overflowY = "hidden";
      // document.body.classList.add('no-scroll');
    }
    function FriendFunRmv() {
      document.querySelector("#frndlist").style.display = "none";
      document.querySelector(".blurzone").style.display = "none";
      
      // document.body.classList.remove('no-scroll');
      // document.querySelector("body").style.overflowY = "auto";
    }

    function newpg(X) {
      window.location.href = `OtherProfile.php?oth=${X}`;

    }

    let urlprof = window.location.href;
    const url = urlprof.replace("SelfProfile.php", "OtherProfile.php?oth=<?php echo $_SESSION['UserName']; ?>");
    const profileUrl = url;
    const profileTitle = "Check out my profile";
    const profileText = "Here is a link to my online profile.";

    // Get the button element
    const shareButton = document.getElementById('shareProfileButton');

    // Add click event listener
    shareButton.addEventListener('click', async () => {
      // Check if the Web Share API is supported by the browser
      if (navigator.share) {
        try {
          // Attempt to use the native share functionality
          await navigator.share({
            title: profileTitle, // Optional: A title for the shared content
            text: profileText,   // Optional: Some accompanying text
            url: profileUrl      // The actual link you want to share
          });
          console.log('Profile shared successfully');
        } catch (error) {
          // Handle errors (e.g., user cancelled the share)
          console.error('Error sharing profile:', error);
        }
      } else {
        // Fallback for browsers that do not support the API
        alert("Your browser does not support the native share dialogue. You can copy the link manually: " + profileUrl);
        // Alternatively, you can implement a custom modal dialogue here as a fallback
      }
    });



        function postpg(PostId, path, caption, uidd) {
          caption = caption.trim();
        
        
          const url = `PostView.php?id=${PostId}&path=${encodeURIComponent(path)}&caption=${encodeURIComponent(caption)}&uidd=${uidd}`;
          
          window.location.href = url;
        }
  </script>
</body>

</html>