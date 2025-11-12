<?php
session_start();

include('config.php');
include("LoggedIn.php");
$cmnt = "";
$oth = $_GET['oth'];

if ($oth == $_SESSION['UserName']) {
  header("location:SelfProfile.php");
}

$sql = "SELECT UserId,Profile_picture,website from users where UserName='" . $oth . "';";
$res = $conn->query($sql);
if ($res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $oid = $row["UserId"];
    $pf = $row["Profile_picture"];
    $osite = $row['website'];
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Other Profile</title>
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
      background: url('<?php echo $pf; ?>') no-repeat center/cover;
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
      cursor: pointer;
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
      /* cursor: pointer; */
    }

    .bottom-nav a:hover,
    .bottom-nav a.active {
      color: #f56040;
      transform: translateY(-3px);
    }

    #frndcnt {
      font-size: 18px;
      color: #555;
      margin-bottom: 25px;
      cursor: pointer;
      font-weight: normal;
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
    }

    #frndlist {
      background-color: white;
      height: 100vh;
      width: 40%;
      position: fixed;
      top: 100px;
      right: 0px;
      display: none;
      align-items: start;
      justify-content: start;
      flex-direction: column;
      gap: 5px;
      padding-left: 5px;
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      border-top: 1px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.1);
      z-index: 102;

      animation: introlst 0.5s ease-in-out;
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
      height: 50px;
      width: 50px;
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
  </style>
</head>

<body>

  <!-- Header -->
  <header class="app-header">
    <img src="./Assets/logo.jpeg" id="logo">
    <!-- <h1 class="logo"></h1> -->
    <h1 class="logo" id="ConnectUs">ConnectUs</h1>
  </header>

  <!-- Profile Top Section -->
  <section class="profile-top">
    <div class="profile-pic"></div>


    <div class="profile-info">
      <div class="username">@<?php echo $oth; ?></div>
      <div class="connections"><span><?php



      $sql = "SELECT COUNT(*) AS postCount FROM posts WHERE UserId=" . $oid . ";";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['postCount'];

      ?></span> Posts | <span onclick="FriendFun()"><?php

      $sql = "SELECT COUNT(*) AS friendCount FROM friends WHERE UserId=" . $oid . " OR FriendId=" . $oid . ";";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['friendCount'];

      ?></span><span id="frndcnt" onclick="FriendFun()"> Friends</span> </div>
      <div class="button-row">
        <form method="post" >
          <button class="edit-btn" id="frndbtn" name="frndconn" type="submit">

            <?php



            $sql = "SELECT * FROM friends WHERE UserId=" . $_SESSION['UID'] . " AND FriendId=" . $oid . " OR FriendId=" . $_SESSION['UID'] . " AND UserId=" . $oid . ";";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($row) {
              $cmnt = "Friends ✔";
            } else {
              $cmnt = "Add Friend";
            }



            if (isset($_POST['frndconn'])) {
              if ($cmnt == "Add Friend") {
                $sql = "INSERT INTO friends (FriendId,UserId) VALUES (" . $oid . "," . $_SESSION['UID'] . ")";
                $conn->query($sql);

                $sql = "INSERT INTO notifications (fromId,toId,msg,fromppf,label,FromName) VALUES (" . $_SESSION['UID'] . "," . $oid . ",'added you as a Friend','" . $_SESSION['Profile_picture'] . "','friend','" . $_SESSION['UserName'] . "')";
                $conn->query($sql);

                $cmnt = "Friends ✔";
              } elseif ($cmnt == "Friends ✔") {
                $sql = "DELETE FROM friends Where FriendId=" . $oid . " AND UserId=" . $_SESSION['UID'] . " OR FriendId=" . $_SESSION['UID'] . " AND UserId=" . $oid . ";";
                $conn->query($sql);

                $sql = "DELETE FROM notifications WHERE toId=" . $oid . " AND fromId=" . $_SESSION['UID'] . " AND label='friend';";
                $conn->query($sql);


                $cmnt = "Add Friend";
              }
            }


            echo $cmnt;


            ?>
          </button>
        </form>
        <button class="share-btn">Message</button>
      </div>
    </div>

    <div class="bio-section">
      <div class="bio-title">About Me</div>
      <div class="bio">
        <?php $sql = "SELECT bio FROM users WHERE UserName='" . $oth . "';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['bio']; ?>
        <br>
        <?php
        if (isset($osite)) {
          if (str_contains($osite, "https://") || str_contains($osite, "http://")) {
            echo "<a href='" . $osite . "' target='_blank'><i class='fa-solid fa-link'></i></a>";

          } else {
            echo "<a href='https://" . $osite . "' target='_blank'><i class='fa-solid fa-link'></i></a>";
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


      $sql = "SELECT path,caption,created_at,PostId from posts where UserId=" . $oid . " ORDER BY created_at DESC;";
      $res = $conn->query($sql);
      if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {

          echo "<div class='post' onclick='postpg(" . $row['PostId'] . ",`" . $row['path'] . "`,`" . $row['caption'] . "`," . $oid . ")'>
            <img src='" . $row['path'] . "'>
            <div class='post-overlay'>
              <div class='post-icons'>" . $row['caption'] . "</div>
              <div class='post-counts'>1.2K Likes • 80 Comments</div>
            </div>
          </div>";


        }
      } else {
        echo "No Uploads";
      }


      ?>

      <div class="blurzone" onclick="FriendFunRmv()"></div>
      <div id="frndlist">
        <div onclick="FriendFunRmv()">X</div>
        <hr>
        <?php
        $sql = "SELECT 
    u.UserId,
    u.UserName,
    u.Profile_picture
FROM users u
WHERE u.UserId IN ( SELECT CASE WHEN f.UserId = " . $oid . " THEN f.FriendId ELSE f.UserId END AS Friend FROM friends f WHERE f.UserId = " . $oid . " OR f.FriendId = " . $oid . " ) ORDER BY created_at DESC;";
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
    }
    function FriendFunRmv() {
      document.querySelector("#frndlist").style.display = "none";
      document.querySelector(".blurzone").style.display = "none";
    }

    function newpg(X) {
      window.location.href = `OtherProfile.php?oth=${X}`;

    }



    function postpg(PostId, path, caption, uidd) {
      caption = caption.trim();
      const url = `PostView.php?id=${PostId}&path=${encodeURIComponent(path)}&caption=${encodeURIComponent(caption)}&uidd=${uidd}`;
      window.location.href = url;
    }

  </script>
</body>

</html>