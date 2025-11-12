<?php
session_start();
include("config.php");
include("LoggedIn.php");
$PID = $_GET['id'];
$path = $_GET['path'];
// $caption = $_GET['caption'];
$uid = $_GET['uidd'];
$ppf = '';
$fromName = '';
$sql = "SELECT caption from posts WHERE PostId=" . $PID . ";";
$res = $conn->query($sql);
if ($res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $caption = $row['caption'];
  }
}



if (isset($_POST['addcmt'])) {
  $cmt = $_POST['cmt'];
  if ($cmt) {
    $sql = "INSERT INTO comments (UserId,PostId,Comment_Text) values (" . $_SESSION['UID'] . "," . $PID . ",'" . $cmt . "');";
    $conn->query($sql);

    $sql = " INSERT INTO notifications (fromId, toId, msg, postId, fromppf, postPreview, label, fromName) VALUES (" . $_SESSION['UID'] . "," . $uid . ",' commented ` " . $cmt . " ` on your post'," . $PID . ",'" . $_SESSION['Profile_picture'] . "','" . $path . "','Comments','" . $_SESSION['UserName'] . "')";
    $conn->query($sql);

  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Post View</title>
  <?php include("LinkConfig.php"); ?>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #333;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    /* Header */
    .app-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 40px;
      width: 100%;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.4);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      font-size: 24px;
      font-weight: 700;
      color: #222;
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
      transition: 0.3s;
    }

    .chat-btn:hover {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #fff;
      transform: scale(1.1);
    }

    /* Post Container */
    .post-container {
      flex: 1;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 0;
    }

    .post-card {
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      max-width: 900px;
      width: 90%;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .post-image {
      width: 100%;
      background: #eee;
      overflow: hidden;
    }

    .post-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: 0.3s;
    }

    .post-image img:hover {
      transform: scale(1.03);
    }

    .post-details {
      padding: 25px 30px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 15px;

    }

    .user-info img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      border: 3px solid #f56040;
      cursor: pointer;
    }

    .user-info h3 {
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }

    .caption {
      font-size: 14px;
      margin-bottom: 18px;
      line-height: 1.5;
      color: #444;
    }

    .post-stats {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      margin-bottom: 15px;
    }

    .stat {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 500;
      color: #333;
      cursor: pointer;
      transition: 0.3s;
      font-size: 20px;
    }

    .stat:hover {
      color: #000000;
      transform: scale(1.05);
    }

    .comments-section {
      flex-grow: 1;
      overflow-y: auto;
      max-height: 150px;
      padding-right: 5px;
      margin-bottom: 15px;
    }

    .comment {
      margin-bottom: 10px;
      display: flex;
      gap: 10px;
    }

    .comment img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }

    .comment .text {
      background: rgba(0, 0, 0, 0.05);
      padding: 7px 10px;
      border-radius: 10px;
      font-size: 13px;
    }

    .add-comment {
      display: flex;
      margin-top: 10px;
    }

    .add-comment input {
      flex: 1;
      padding: 8px 12px;
      border-radius: 10px 0 0 10px;
      border: 1px solid #ccc;
      outline: none;
      font-size: 13px;
    }

    .add-comment button {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #fff;
      border: none;
      border-radius: 0 10px 10px 0;
      padding: 8px 16px;
      cursor: pointer;
      font-size: 13px;
      transition: 0.3s;
    }

    .add-comment button:hover {
      transform: scale(1.05);
    }

    /* Bottom Nav */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 65px;
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
      font-size: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: 0.3s;
    }

    .bottom-nav a span {
      font-size: 10px;
    }

    .bottom-nav a:hover,
    .bottom-nav a.active {
      color: #000000;
      transform: translateY(-3px);
    }

    .stat span {
      cursor: pointer;
    }

    .stat button {
      cursor: pointer;
      background: none;
      border: none;
      font-size: 22px;
      user-select: none;

    }

    @media (max-width: 800px) {
      .post-card {
        grid-template-columns: 1fr;
        max-width: 500px;
      }

      .post-image {
        height: 300px;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="app-header">
    <h1 class="logo">Post</h1>
  </header>

  <!-- Compact Post Viewer -->
  <section class="post-container">
    <div class="post-card">
      <div class="post-image">
        <img src="<?php echo $path; ?>" alt="Post">
      </div>

      <div class="post-details">
        <div>


          <?php

          $sql = "SELECT UserName,Profile_picture from users where UserId=" . $uid . ";";
          $res = $conn->query($sql);
          if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
             
              echo "<div class='user-info'>
                    <img src='" . $row['Profile_picture'] . "' alt='User' onclick=newpg('" . $row['UserName'] . "')>
                    <h3 onclick=newpg('" . $row['UserName'] . "')>@" . $row['UserName'] . "</h3>
                  </div>";
            }
          }
          ?>



          <p class="caption"><?php echo $caption; ?></p>

          <div class="post-stats">
            <?php

            $sqll = "SELECT COUNT(*) AS like_count from likes where UserId=" . $_SESSION['UID'] . " AND PostId=" . $PID . ";";
            $ress = $conn->query($sqll);
            if ($ress->num_rows > 0) {


              while ($likerow = $ress->fetch_assoc()) {
                $liked = $likerow['like_count'];

                if ($liked) {

                  $likeicon = "<i class='fa-solid fa-heart' style='color: #b80000;'></i>";
                } else {

                  $likeicon = "<i class='fa-regular fa-heart'></i>";
                }
              }
            }

            $sqll = "SELECT COUNT(*) AS like_count from likes where PostId=" . $PID . ";";
            $ress = $conn->query($sqll);
            if ($ress->num_rows > 0) {


              while ($likerow = $ress->fetch_assoc()) {
                $likecount = $likerow['like_count'];


              }
            }

            echo '<div class="stat"><button class="likeBtn" name="like" data-postid="' . $PID . '" data-userid="' . $_SESSION['UID'] . '" >' . $likeicon . '</button> <span id="likecount" style="font-size:17px;">' . $likecount . '</span></div>';


            ?>

            <?php

            $sql = "SELECT COUNT(*) AS count from comments WHERE postId =" . $PID . " ;";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
              while ($row = $res->fetch_assoc()) {
                $cmtcount = $row['count'];
              }
            }

            ?>

            <div class="stat"><i class='fa-regular fa-comment-dots'></i> <?php echo $cmtcount; ?></div>
            <?php echo "<div  class='stat' id='shareProfileButton' onclick='sharepost(" . $PID . ",`" . $path . "`,`" . $caption . "`," . $uid . ")'><i class='fa-regular fa-paper-plane'></i></div>"; ?>
          </div>


          <div class="comments-section">

            <?php


            $sql = "SELECT C.Comment_Text AS cmt,U.UserName AS name,U.Profile_picture AS ppf FROM comments AS C JOIN users AS U WHERE C.UserId=U.UserId AND PostId=" . $PID . " ;";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
              while ($row = $res->fetch_assoc()) {
                echo "<div class='comment'>
              <img src='" . $row['ppf'] . "'>
              <div class='text'><strong>@" . $row['name'] . "</strong>  " . $row['cmt'] . "</div>
            </div>
";
              }
            }

            ?>




           
          </div>
        </div>

        <form method="POST" autocomplete="off">
          <div class="add-comment">
            <input type="text" name="cmt" placeholder="Add a comment...">
            <button type="submit" name="addcmt">Post</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <?php include("Navbar.php"); ?>


  <script>
    function newpg(X) {
      window.location.href = `OtherProfile.php?oth=${X}`;

    }

    const btn = document.querySelector(".likeBtn");
    btn.addEventListener("click", async () => {
      const post_id = btn.dataset.postid;
      const user_id = btn.dataset.userid;

      const countEl = btn.closest(".post-stats").querySelector("#likecount");

      try {
        const response = await fetch("like.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `post_id=${encodeURIComponent(post_id)}&user_id=${encodeURIComponent(user_id)}`
        });

        if (!response.ok) throw new Error("Network error");

        const data = await response.json();


        countEl.textContent = data.total;
        if (data.liked) {
          btn.querySelector("i").className = "fa-solid fa-heart";
          btn.querySelector("i").style.color = "#b80000";
        } else {
          btn.querySelector("i").className = "fa-regular fa-heart";
          btn.querySelector("i").style.color = "";
        }
      } catch (error) {
        console.error("Error:", error);
      }
    });



    async function sharepost(PostId, path, caption, uidd) {

      let shareButton = document.getElementById('shareProfileButton');

      let urlprof = window.location.href;
      let url = urlprof.replace("Home.php", `PostView.php?id=${PostId}&path=${encodeURIComponent(path)}&caption=${encodeURIComponent(caption)}&uidd=${uidd}`);
      let profileUrl = url;
      let profileTitle = "Check out this post";
      let profileText = "Here is a link to a post.";

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
      } // Get the button element
    }


  </script>
</body>

</html>