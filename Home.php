<?php
session_start();
include("config.php");
include("LoggedIn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("LinkConfig.php"); ?>
  <title>Home</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      background-attachment: fixed;
      color: #333;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

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

    /* Chat button style */
    .chat-btn {
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
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

    /* ---------- STORIES ---------- */
    .stories {
      display: flex;
      overflow-x: auto;
      gap: 12px;
      padding: 12px 14px;
      background: #fff;
      border-bottom: 1px solid #ddd;
      width: 100%;
      max-width: 600px;
      scroll-behavior: smooth;
    }

    .stories::-webkit-scrollbar {
      display: none;
      /* Hide scrollbar */
    }

    .story {
      flex: 0 0 auto;
      width: 75px;
      text-align: center;
    }

    .story img {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      border: 2px solid #f56040;
      object-fit: cover;
      transition: transform 0.2s ease;
    }

    .story img:hover {
      transform: scale(1.1);
    }

    .story p {
      font-size: 12px;
      margin-top: 5px;
      color: #555;
    }

    /* ---------- FEED ---------- */
    .feed {
      width: 100%;
      max-width: 600px;
      margin-top: 0%;
      margin-bottom: 65px;
      background-color: #fff;

    }

    .post {
      padding: 10px;
      background: #fff;
      margin: 15px 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .post-header {
      display: flex;
      align-items: center;
      padding: 12px;
    }

    .post-header img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .post-header h4 {
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
    }

    .post-image {
      width: 100%;
      height: 360px;
      object-fit: cover;
    }

    .post-actions {
      padding: 10px 15px;
      display: flex;
      gap: 12px;
      font-size: 22px;
      user-select: none;
    }

    .post-caption {
      padding: 0 15px 12px 15px;
      font-size: 15px;
      color: #444;
    }

    /* ---------- MODERN BOTTOM NAV ---------- */
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

    .point {
      cursor: pointer;
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

    /* Hide scrollbar in stories */
    .stories::-webkit-scrollbar {
      display: none;
    }

    span i {
      cursor: pointer;
    }

    span button {
      cursor: pointer;
      background: none;
      border: none;
      font-size: 22px;
      user-select: none;

    }

    /* Responsive */
    @media (max-width: 650px) {

      .feed,
      .stories {
        max-width: 100%;
      }

      .post-image {
        height: 300px;
      }
    }
  </style>
</head>

<body>
  <header class="app-header">
    <img src="./Assets/logo.jpeg" id="logo">
    <h1 class="logo">ConnectUs</h1>
    <button class="chat-btn" title="Messages"><i class="fa-regular fa-comments"></i></button>
  </header>

  <!-- Stories -->

  <div class="stories">
    <div class="story"><img src="<?php echo $_SESSION['Profile_picture']; ?>" alt="">
      <p>You</p>
    </div>


    <?php
    //  $sql = "SELECT UserName,Profile_picture FROM users where UserId IN (SELECT e1.FriendId AS FID,e2.UserId AS UID FROM friends AS e1 INNER JOIN friends AS e2 ON e1.UserId = e2.FriendId) ORDER BY created_at DESC;";
    $sql = "SELECT 
    u.UserId,
    u.UserName,
    u.Profile_picture
FROM users u
WHERE u.UserId IN ( SELECT CASE WHEN f.UserId = " . $_SESSION['UID'] . " THEN f.FriendId ELSE f.UserId END AS Friend FROM friends f WHERE f.UserId = " . $_SESSION['UID'] . " OR f.FriendId = " . $_SESSION['UID'] . " ) ORDER BY created_at DESC;";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {

      while ($row = $res->fetch_assoc()) {
        echo " <div class='story'><img src='" . $row['Profile_picture'] . "' alt=''>
      <p>" . $row['UserName'] . "</p>
    </div>";
      }
    }

    ?>




  </div>
  <!-- Feed -->
  <div class="feed list-view">
    <div class="post">


      <?php




      // $sql = "SELECT posts.path AS path,posts.caption AS caption,posts.created_at,users.UserName AS UserName,users.Profile_picture AS ppf from posts inner join users ON posts.UserId=(SELECT FriendId AS fid FROM friends WHERE UserId=" . $_SESSION['UID'] . ") AND users.UserId=" . $_SESSION['UID'] . " ORDER BY posts.created_at DESC;";
      $sql = "SELECT posts.path AS path,posts.caption AS caption,posts.created_at AS timePost,users.UserName AS UserName,users.Profile_picture AS ppf,users.UserId as uidd,posts.PostId AS PostID FROM posts INNER JOIN users ON posts.UserId = users.UserId WHERE posts.UserId = " . $_SESSION['UID'] . " OR posts.UserId IN (SELECT CASE WHEN f.UserId = " . $_SESSION['UID'] . " THEN f.FriendId ELSE f.UserId END AS Friend FROM friends f WHERE f.UserId = " . $_SESSION['UID'] . " OR f.FriendId = " . $_SESSION['UID'] . ") ORDER BY posts.created_at DESC;";
      $res = $conn->query($sql);
      if ($res->num_rows > 0) {

        while ($row = $res->fetch_assoc()) {

          $sqlTimestamp = $row['timePost']; // Example SQL timestamp
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

          $sqll = "SELECT COUNT(*) AS like_count from likes where UserId=" . $_SESSION['UID'] . " AND PostId=" . $row['PostID'] . ";";
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


           $sqll = "SELECT COUNT(*) AS like_count from likes where PostId=" . $row['PostID'] . ";";
          $ress = $conn->query($sqll);
          if ($ress->num_rows > 0) {


            while ($likerow = $ress->fetch_assoc()) {
              $likecount = $likerow['like_count'];

            
            }
          }


          echo " <div class='post-header' onclick=newpg('" . $row['UserName'] . "')>
        <img class='point' src='" . $row['ppf'] . "' alt=''' onclick=newpg('" . $row['UserName'] . "')>
        <h4 onclick=newpg('" . $row['UserName'] . "')>" . $row['UserName'] . "</h4>
      </div>
      <img src='" . $row['path'] . "' alt='' class='post-image'>
      <div class='post-actions'>




<span><button class='likeBtn' type='submit' name='like' data-postid='" . $row['PostID'] . "' data-userid='" . $_SESSION['UID'] . "' >" . $likeicon . "</button><span id='likecount' style='font-size:17px;'>" . $likecount . "</span></span> 
        
        <span onclick='postpg(" . $row['PostID'] . ",`" . $row['path'] . "`,`" . $row['caption'] . "`," . $row['uidd'] . ")'><i class='fa-regular fa-comment-dots'></i></span> 
        
        <span id='shareProfileButton' onclick='sharepost(" . $row['PostID'] . ",`" . $row['path'] . "`,`" . $row['caption'] . "`," . $row['uidd'] . ")'><i class='fa-regular fa-paper-plane'></i></span>

        
      </div>
      <div class='post-caption'>
        <b class='point' onclick=newpg('" . $row['UserName'] . "')>" . $row['UserName'] . "</b> " . $row['caption'] . "
      </div>
      <div style='margin-left:15px;'>" . $timeAgo . "</div>
    ";
        }

      } else {
        echo "No Updates Yet";
      }
      ?>


    </div>

    <!-- Bottom Navigation -->
    <!-- <div class="bottom-nav">
    <a href="feed.html">🏠<span>Home</span></a>
    <a href="search.html">🔍<span>Search</span></a>
    <a href="post.html">➕<span>Post</span></a>
    <a href="notifications.html">❤️<span>Likes</span></a>
    <a href="#">👤<span>Profile</span></a>
  </div> -->
    <?php include("Navbar.php"); ?>

    <script>

      function newpg(X) {
        window.location.href = `OtherProfile.php?oth=${X}`;

      }

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

      function postpg(PostId, path, caption, uidd) {
        caption = caption.trim();


        const url = `PostView.php?id=${PostId}&path=${encodeURIComponent(path)}&caption=${encodeURIComponent(caption)}&uidd=${uidd}`;

        window.location.href = url;
      }


      function handleSubmit(event) {
        event.preventDefault(); // Prevents the default form submission (page reload)
      }


      // function ajaxpg(pid,uid){
      //   fetch(`likeajax.php?pid=${encodeURIComponent(pid)}&uid=${ encodeURIComponent(uid)}`).then(data => {
      //     document.querySelector("#like_count")=data.likecount;
      //     document.querySelector("isliked")=data.isliked;

      //   })
      // }
      document.querySelectorAll(".likeBtn").forEach(btn => {
        btn.addEventListener("click", async () => {
          const post_id = btn.dataset.postid;
          const user_id = btn.dataset.userid;
          const countEl = btn.closest(".post-actions").querySelector("#likecount");

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
      });


      

    </script>

    <!-- <script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;4f175b1ac3204b9ca216125bb4bd6018&quot;,&quot;r&quot;:1,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}" crossorigin="anonymous"></script> -->


</body>

</html>


<!-- $sqll = "SELECT COUNT(*) AS like_count from likes where UserId=" . $_SESSION['UID'] . " AND PostId=" . $row['PostID'] . ";";
          $ress = $conn->query($sqll);
          if ($ress->num_rows > 0) {
            

            while ($likerow = $ress->fetch_assoc()) {
              $likecount = $likerow['like_count'];
             
             
            }
          }

          if (isset($_POST['like'])) {
            if ($likecount) {
              $sqll = "DELETE FROM likes where UserId=" . $_SESSION['UID'] . " AND PostId=" . $row['PostID'] . ";";
              $conn->query($sqll);
              $likeicon = "<i class='fa-regular fa-heart'></i>";
            } 
            else {
              $sqll = "INSERT INTO likes (UserId,PostId) values (" . $_SESSION['UID'] . "," . $row['PostID'] . ");";
              $conn->query($sqll);
              $likeicon = "<i class='fa-solid fa-heart' style='color: #b80000;'></i>";
            }
          }



          if ($likecount) {

            $likeicon = "<i class='fa-solid fa-heart' style='color: #b80000;'></i>";
          } else {
            $likeicon = "<i class='fa-regular fa-heart'></i>";
          } -->