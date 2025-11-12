<?php
session_start();
include("config.php");
include("LoggedIn.php");


if (isset($_POST['cancel'])) {
  header('location:SelfProfile.php');
}

if (isset($_POST['save'])) {
  $website = $_POST['website'];
  $email = $_POST['email'];
  $bio = $_POST['bio'];

  if ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/jpg' || $_FILES['photo']['type'] == 'image/png') {
    print_r($_FILES['photo']);
    $fname = $_FILES['photo']['name'];
    $fsize = $_FILES['photo']['size'];
    $ftmp = $_FILES['photo']['tmp_name'];

    $use = $_SESSION['UserName'];
    $uid = $_SESSION['UID'];
    $fpath = './Uploads/';
    $src = $fpath . "Prof" . $use . $uid . $fname;
    move_uploaded_file($ftmp, $src);

    unlink($_SESSION['Profile_picture']);

    $_SESSION['Profile_picture'] = $src;

    $sql = "UPDATE users SET Profile_picture='$src' WHERE UserId=" . $_SESSION['UID'] . ";";
    $conn->query($sql);

  $sql = "UPDATE notifications SET fromppf='$src' WHERE FromName='" . $_SESSION['UserName'] . "';";
    $conn->query($sql);

  } else {
    $msg = 'Invalid File Type';
    $css = "border:4px solid crimson;";
  }

  if ($_POST['bio']) {
    $_SESSION['bio'] = $bio;
    $sql = "UPDATE users SET bio='$bio' WHERE UserId=" . $_SESSION['UID'] . ";";
    $conn->query($sql);
  }

  if ($_POST['email']) {
    $_SESSION['Email'] = $email;
    $sql = "UPDATE users SET Email='$email' WHERE UserId=" . $_SESSION['UID'] . ";";
    $conn->query($sql);
  }
  if ($_POST['website']) {
    $_SESSION['Website'] = $website;
    $sql = "UPDATE users SET website='$website' WHERE UserId=" . $_SESSION['UID'] . ";";
    $conn->query($sql);
  }


  header("location:SelfProfile.php");


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <?php include("LinkConfig.php"); ?>
  <style>
    /* Basic Reset */
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
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Header */
    .app-header {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 40px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.4);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      font-size: 28px;
      font-weight: 700;
      color: #222;
      letter-spacing: 0.5px;
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
      transition: all 0.25s ease-in-out;
    }

    .chat-btn:hover {
      background: linear-gradient(45deg, #f56040, #fcaf45);
      color: #fff;
      transform: scale(1.08);
    }

    /* Edit Profile Main Container */
    .edit-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 5%;

    }

    .edit-card {
      width: 100%;
      max-width: 950px;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(15px);
      border-radius: 25px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      padding: 50px 60px;
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 40px;
      animation: fadeIn 0.8s ease;
      <?php if (isset($css))
        echo $css; ?>
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

    /* Left section - Profile photo */
    .profile-left {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      margin-top: 100px;
    }

    .profile-left img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      border: 4px solid #f56040;
      object-fit: cover;
      margin-bottom: 15px;
      transition: 0.3s;
    }

    .profile-left img:hover {
      transform: scale(1.05);
    }

    .profile-left label {
      color: #f56040;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .profile-left label:hover {
      color: #fcaf45;
    }

    input[type="file"] {
      display: none;
    }

    /* Right section - Form */
    .form-right {
      display: flex;
      flex-direction: column;
    }

    .form-right h2 {
      font-size: 28px;
      margin-bottom: 30px;
      font-weight: 700;
      text-align: center;
      color: #222;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #444;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 12px 15px;
      border-radius: 10px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      outline: none;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.8);
      transition: all 0.3s ease;
    }

    input:focus,
    textarea:focus {
      border-color: #f56040;
      box-shadow: 0 0 0 3px rgba(245, 96, 64, 0.2);
    }

    textarea {
      resize: none;
      height: 100px;
    }

    .btn-row {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 35px;
    }

    .save-btn,
    .cancel-btn {
      padding: 12px 30px;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .save-btn {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #fff;
    }

    .save-btn:hover {
      transform: scale(1.07);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .cancel-btn {
      background: rgba(0, 0, 0, 0.08);
      color: #333;
    }

    .cancel-btn:hover {
      background: rgba(0, 0, 0, 0.15);
      transform: scale(1.07);
    }

    /* Bottom Nav */
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

    s .bottom-nav a:hover,
    .bottom-nav a.active {
      color: #000000;
      transform: translateY(-3px);
    }

    @media (max-width: 850px) {
      .edit-card {
        grid-template-columns: 1fr;
        padding: 35px 25px;
      }

      .profile-left {
        margin-bottom: 30px;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="app-header">
    <h1 class="logo">Edit Profile</h1>
    <!-- <button class="chat-btn">💬</button> -->
  </header>

  <!-- Edit Profile Section -->
  <section class="edit-wrapper">
    <form class="edit-card" method="POST" autocomplete="off" enctype="multipart/form-data">
      <!-- Left -->
      <div class="profile-left">
        <img src="<?php echo $_SESSION['Profile_picture']; ?>" alt="Profile Photo" id="preview-pic">
        <label for="profile-pic">Change Profile Photo</label>
        <input type="file" id="profile-pic" accept="image/*" name="photo">
        <?php if (isset($msg))
          echo $msg; ?>
      </div>

      <!-- Right -->
      <div class="form-right">
        <h2>Profile Details</h2>



        <div class="form-group">
          <label>Website</label>
          <input type="text" name="website" placeholder="Your website (optional)">
        </div>

        <div class="form-group">
          <label>Bio</label>
          <textarea placeholder="Tell something about yourself..." name="bio"></textarea>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" placeholder="Enter your email" name="email">
        </div>

        <div class="btn-row">
          <button class="save-btn" type="submit" name="save">Save Changes</button>
          <button class="cancel-btn" type="submit" name="cancel">Cancel</button>
        </div>
      </div>
    </form>
  </section>

  <!-- Bottom Navigation -->
  <script>
    const fileInput = document.getElementById('profile-pic');
    const previewImg = document.getElementById('preview-pic');
    const imageBox = document.getElementById('profile-left');
    // const uploadText = imageBox.querySelector('.upload-text');

    fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImg.src = e.target.result;
          previewImg.style.display = "block";
          // uploadText.style.display = "none";
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>

</html>