<?php 
session_start();
include('config.php');
include("LoggedIn.php");

if(isset($_POST['upload'])){
  if(isset($_FILES['photo'])){
    if ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/jpg' || $_FILES['photo']['type'] == 'image/png') {
        
        $fname = $_FILES['photo']['name'];
        $fsize = $_FILES['photo']['size'];
        $ftmp = $_FILES['photo']['tmp_name'];

        $use = $_SESSION['UserName'];
        $uid = $_SESSION['UID'];
        $fpath = './Uploads/';
        $src = $fpath."post" . $use . $uid . $fname;
        move_uploaded_file($ftmp, $src);

        $caption = $_POST['caption'];
       
        $sql="INSERT INTO posts (UserId,path,caption) values ($uid,'$src','$caption')";
        $conn->query($sql);

        header("location:Home.php");
        
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Post | Social App</title>
   <?php include("LinkConfig.php");?>

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
    }

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
     .app-header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content:space-between;
    padding: 15px 20px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.4);
    position: sticky;  /* stays at the top while scrolling */
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
    
    #logo{
    height: 60px;
    width: 60px;
    border-radius: 50%;
  }

    .post-form {
      background: #fff;
      margin-top: 90px;
      padding: 25px;
      width: 90%;
      max-width: 480px;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .post-form:hover {
      transform: translateY(-3px);
    }

    .post-form h2 {
      text-align: center;
      color: #222;
      margin-bottom: 15px;
      font-size: 22px;
    }

    /* -------- Image Upload Box -------- */
    .image-upload-box {
      border: 2px dashed #ccc;
      border-radius: 15px;
      height: 280px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      overflow: hidden;
      transition: border-color 0.3s ease;
      background: #fafafa;
    }

    .image-upload-box:hover {
      border-color: #f56040;
    }

    .image-upload-box img {
      width: 100%;
      height: 100%;
      object-fit: contain; /* Shows full image */
      background: #fff;
    }

    .upload-text {
      color: #777;
      font-size: 16px;
      text-align: center;
    }

    input[type="file"] {
      display: none;
    }

    textarea {
      margin-top: 20px;
      resize: none;
      height: 100px;
      border-radius: 12px;
      padding: 10px;
      border: 1px solid #ccc;
      font-size: 14px;
      outline: none;
      width: 100%;
      transition: all 0.2s ease;
    }

    textarea:focus {
      border-color: #f56040;
      box-shadow: 0 0 6px rgba(245,96,64,0.3);
    }

    button {
      width: 100%;
      background: #f56040;
      border: none;
      color: #fff;
      padding: 12px;
      font-size: 16px;
      border-radius: 30px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 20px;
      transition: all 0.3s ease;
    }

    button:hover {
      background: #e14c2d;
      transform: translateY(-2px);
    }

    /* -------- Bottom Nav -------- */
    .bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 70px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    backdrop-filter: blur(12px); /* main blur effect */
    -webkit-backdrop-filter: blur(12px);
    background: rgba(255, 255, 255, 0.3); /* glass transparency */
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
  </style>
</head>
<body>

  <header class="app-header">
    <img src="./Assets/logo.jpeg" id="logo">
    <h1 class="logo">Create Post</h1>
    <h1 class="logo">ConnectUs</h1>
  </header>

  <form class="post-form" action="#" method="post" enctype="multipart/form-data">
    <h2>Share Your Post</h2>

    <!-- Image upload box -->
    <label for="photo" class="image-upload-box" id="imageBox">
      <span class="upload-text">Click to choose an image</span>
      <img id="preview" src="" alt="" style="display:none;">
    </label>
    <input type="file" id="photo" name="photo" accept="image/*" required>

    <textarea id="caption" name="caption" placeholder="Write a caption..." required></textarea>

    <button type="submit" name="upload">Post Now</button>
  </form>

  <!-- Bottom Navigation -->
  <!-- <div class="bottom-nav">
    <a href="feed.html">🏠<span>Home</span></a>
    <a href="search.html">🔍<span>Search</span></a>
    <a href="post.html" style="color:#f56040;">➕<span>Post</span></a>
    <a href="notifications.html">❤️<span>Likes</span></a>
    <a href="#">👤<span>Profile</span></a>
  </div> -->
<?php include("Navbar.php"); ?>
  <!-- Small JS for Image Preview -->
  <script>
    const fileInput = document.getElementById('photo');
    const previewImg = document.getElementById('preview');
    const imageBox = document.getElementById('imageBox');
    const uploadText = imageBox.querySelector('.upload-text');

    fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImg.src = e.target.result;
          previewImg.style.display = "block";
          uploadText.style.display = "none";
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>
</html>
