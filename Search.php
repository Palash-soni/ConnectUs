<?php
session_start();
include("config.php");
include("LoggedIn.php");

$cmnt = '';



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search | Social App</title>
  <?php include("LinkConfig.php"); ?>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    /* -------- SEARCH BAR -------- */
    .search-bar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      /* background: #fff; */
      backdrop-filter: blur(12px);
      /* main blur effect */
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      /* glass transparency */
      border-bottom: 1px solid #ddd;
      padding: 10px 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 10;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .logo {
      font-size: 24px;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
    }

    #logo {
      height: 60px;
      width: 60px;
      border-radius: 50%;
      justify-content: left;
    }

    .search-container {
      position: relative;
      width: 90%;
      max-width: 550px;
    }

    .search-container input {
      width: 100%;
      padding: 10px 45px;
      font-size: 15px;
      border-radius: 30px;
      border: 2px solid #000000;
      outline: none;
      transition: all 0.2s ease;
      backdrop-filter: blur(12px);
      /* main blur effect */
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      /* glass transparency */
    }

    .search-container input:focus {
      border-color: #f56040;
      box-shadow: 0 0 6px rgba(245, 96, 64, 0.4);
    }

    .search-container i {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #777;
      cursor: pointer;
      user-select: none;
    }

    .search-container .icon-left {
      left: 15px;
    }

    .search-container .icon-right {
      right: 15px;
    }

    /* -------- RESULTS GRID -------- */
    .results {
      margin-top: 85px;
      width: 100%;
      max-width: 600px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 8px;
      padding: 10px;
    }

    .result-item {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .result-item:hover {
      transform: scale(1.03);
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .result-item img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .result-info {
      padding: 8px 10px;
    }

    .result-info h4 {
      font-size: 14px;
      font-weight: 600;
      color: #333;
    }

    .result-info p {
      font-size: 12px;
      color: #777;
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

    #btn{
      position: fixed;
      top: 1.3rem;
      left: 67%;
      right: 0;
      z-index: 2;
      height: 37px;
      width:37px;
     backdrop-filter: blur(12px);
      /* main blur effect */
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      /* glass transparency */
      border-radius: 50%;
      cursor: pointer;
    }

    /* Responsive */
    @media (max-width: 650px) {
      .results {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      }
    }
  </style>
  <!-- Font Awesome for icons -->
  <!-- <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script> -->

    <?php include("LinkConfig.php");?>
</head>

<body>

  <!-- Search Bar -->
  <div class="search-bar">
    <img src="./Assets/logo.jpeg" id="logo">
    <div class="search-container">
      <!-- <form method="post"> -->
        <i class="fas fa-search icon-left"></i>
        <input type="text" placeholder="Search users " name="searchname" id="searchinpt">
        <i class="fas fa-microphone icon-right"></i>
        <!-- <button type="submit" name="search" id="btn"><i class="fas fa-search icon-left"></i> </button>
      </form> -->
    </div>
    <h1 class="logo">ConnectUS</h1>
  </div>

  <?php if (isset($_POST['search']))
    echo $cmnt; ?>
  <!-- Results -->
  <div class="results">
    <?php
    if (isset($_GET['se'])) {
      $inpt = $_GET['se'];
      $sql = "SELECT UserName,Profile_picture,bio,created_at from users where UserName LIKE '%$inpt%' OR UserName LIKE '$inpt%' OR UserName LIKE '%$inpt';";
      $res = $conn->query($sql);
      if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
          echo"<div class='result-item' onclick=newpg('".$row['UserName']."')>
      <img src='".$row['Profile_picture']."' alt=''>
      <div class='result-info'>
        <h4>".$row['UserName']."</h4>
        <p>".$row['bio']."</p>
      </div>
    </div>";

   
        }
      } else {
        echo "User not Found";
      }
    }
    ?>
  </div>

  <?php include("Navbar.php"); ?>

  <script>
    var a;
    function newpg(X){
      window.location.href=`OtherProfile.php?oth=${X}`;
      
    }
  
      const inputElement = document.getElementById("searchinpt");

inputElement.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    // Code to execute when Enter is pressed
     a=event.target.value;
     console.log("Hello");
      window.location.href=`?se=${a}`;
  }
});

    
    
  </script>
</body>

</html>