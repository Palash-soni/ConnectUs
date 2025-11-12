<?php
session_start();
include("config.php");
include("LoggedIn.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications | Social App</title>
  <?php include("LinkConfig.php"); ?>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      padding-bottom: 80px;
    }

    /* -------- HEADER -------- */
    /* header {
      width: 100%;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3); 
      border-bottom: 1px solid #ddd;
      padding: 15px;
      text-align: center;
      font-weight: 600;
      font-size: 18px;
      color: #333;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      position: fixed;
      top: 0;
      left: 0;
      z-index: 10;
    } */
    /* Header container */
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
      /* stays at the top while scrolling */
      top: 0;
      z-index: 100;
    }

    /* App name / logo */
    .app-header .logo {
      font-size: 24px;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
    }

    #logo {
      height: 60px;
      width: 60px;
      border-radius: 50%;
    }

    /* -------- NOTIFICATION LIST -------- */
    .notifications {
      margin-top: 80px;
      width: 100%;
      max-width: 500px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      padding: 10px;
    }

    .notification-card {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 14px;
      padding: 12px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .notification-card:hover {
      transform: translateY(-3px);
    }

    .profile-pic {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      overflow: hidden;
      margin-right: 15px;
      flex-shrink: 0;
      border: 2px solid #f56040;
    }

    .profile-pic img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .notification-text {
      flex: 1;
      color: #444;
      font-size: 14px;
    }

    .notification-text strong {
      color: #222;
      font-weight: 600;
    }

    .notification-time {
      font-size: 12px;
      color: #888;
      margin-top: 3px;
    }

    .preview-img {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      overflow: hidden;
      margin-left: 10px;
      flex-shrink: 0;
    }

    .preview-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* -------- BOTTOM NAV -------- */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 70px;
      display: flex;
      justify-content: space-around;
      align-items: center;
      backdrop-filter: blur(12px);
      /* main blur effect */
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      /* glass transparency */
      border-top: 1px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.1);
      z-index: 100;
      border-radius: 18px 18px 0 0;
    }

    .bottom-nav a {
      text-decoration: none;
      color: #333;
      font-size: 22px;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
    }

    .bottom-nav a span {
      font-size: 11px;
    }

    .bottom-nav a:hover {
      color: #f56040;
      transform: translateY(-3px);
    }

    .bottom-nav a.active {
      color: #f56040;
    }

   

    /* -------- SCROLLBAR HIDE -------- */
    ::-webkit-scrollbar {
      display: none;
    }
  </style>
</head>

<body>
  <header class="app-header">
    <img src="./Assets/Logo.jpeg" id="logo">
    <h1 class="logo"> Notifications</h1>
    <h1 class="logo">ConnectUs</h1>
  </header>

  <div class='notifications'>
    <?php
    $sql = "SELECT fromId,toId,msg,postId,fromppf,postPreview,created_at,label,FromName from notifications WHERE toId=" . $_SESSION['UID'] . " ORDER BY created_at DESC";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) {

        $sqlTimestamp = $row['created_at']; // Example SQL timestamp
        $dateTimeFromDb = new DateTime($sqlTimestamp);
        $currentDateTime = new DateTime(); // Current date and time
        $interval = $currentDateTime->diff($dateTimeFromDb);

        if ($interval->y > 0) {
          $timeAgo = $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
        } elseif ($interval->m > 0) {
          $timeAgo = $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
        } elseif ($interval->d > 0) {
          $timeAgo = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
        } elseif ($interval->h > 0) {
          $timeAgo = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
        } elseif ($interval->i > 0) {
          $timeAgo = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
        } else {
          $timeAgo = "just now";
        }




        if ($row['label'] == "friend") {
          echo "
    
    <div class='notification-card' onclick=newpg('" . $row['FromName'] . "')>
      <div class='profile-pic'>
        <img src='" . $row['fromppf'] . "' alt='user'>
      </div>
      <div class='notification-text'>
        <strong>" . $row['FromName'] . "</strong> " . $row['msg'] . "
        <div class='notification-time'>" . $timeAgo . "</div>
      </div>
    </div>
      ";
        }
        if ($row['label'] == "Likes" || $row['label'] == "Comments") {

          echo "<div class='notification-card'>
      <div class='profile-pic' onclick=newpg('" . $row['FromName'] . "')>
        <img src='" . $row['fromppf'] . "' alt='user'>
      </div>
      <div class='notification-text'>
       <strong onclick=newpg('" . $row['FromName'] . "')>" . $row['FromName'] . "</strong> " . $row['msg'] . "
        <div class='notification-time'>".$timeAgo."</div>
      </div>
      <div class='preview-img' onclick='postpg(" . $row['postId'] . ",`" . $row['postPreview'] . "`," . $row['toId'] . ")'>
        <img src='".$row['postPreview']."' alt='post'>
      </div>
    </div>";

        }



      }
    } else {
      echo "No Updates Yet";
    }

    ?>




    <!-- 
  <div class="notifications"> -->
    <!-- Example Notification 1 -->
    <!-- <div class='notification-card'>
      <div class="profile-pic">
        <img src="https://i.pravatar.cc/150?img=1" alt="user1">
      </div>
      <div class="notification-text">
        <strong>_aarya_</strong> liked your post.
        <div class="notification-time">2 hours ago</div>
      </div>
      <div class="preview-img">
        <img src="https://source.unsplash.com/100x100/?nature" alt="post">
      </div>
    </div> -->


  </div>



  <script>

    function newpg(X) {
      window.location.href = `OtherProfile.php?oth=${X}`;

    }
     function postpg(PostId, path, uidd) {
        // caption = caption.trim();


        const url = `PostView.php?id=${PostId}&path=${encodeURIComponent(path)}&uidd=${uidd}`;

        window.location.href = url;
      }

  </script>

  <?php include("Navbar.php"); ?>
</body>

</html>