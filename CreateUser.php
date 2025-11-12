<?php
session_start();

include("config.php");
$cmnt="";

if (isset($_POST['Next'])) {

  $username = $_POST["Username"];
  $email = $_POST["Email"];


  $sql = "SELECT UserId,UserName,Email,Password,created_at FROM users WHERE BINARY UserName='$username'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $cmnt="User Name Already Exists";
  } else {

    header("location:CreateUser2.php?username=" . urlencode($username) . "&email=" . urlencode($email));

  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <?php include("LinkConfig.php"); ?>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }


    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #808084, #2E2E2C);
    }

    .container {
      display: flex;
      width: 80%;
      max-width: 900px;
      height: 500px;
      background: rgba(255, 255, 255, 0.02);
      border-radius: 30px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .left-section,
    .right-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .left-section {
      border-right: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
      padding: 20px;
    }

    .logo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: url('./Assets/logo.jpeg');
      background-position: center;
      background-size: 160px;
      color: black;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .text {
      font-size: 30px;
      letter-spacing: 1px;
      line-height: 1.4;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .right-section form {
      display: flex;
      flex-direction: column;
      width: 70%;
      color: white;
    }

    .right-section h3 {
      font-size: 14px;
      letter-spacing: 2px;
      margin-bottom: 8px;
    }

    input {
      height: 50px;
      background: transparent;
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 4px;
      padding: 10px;
      margin-bottom: 15px;
      color: white;
      outline: none;
      font-size: 15px;
    }

    .forgot {
      text-align: right;
      font-size: 12px;
      margin-bottom: 20px;
      cursor: pointer;
      color: white;
      text-decoration: none;
    }

    .login-btn {
      background: white;
      color: black;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      padding: 10px;
      height: 51px;
      font-size: 15px;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 20px;
    }

    .login-btn:hover {
      background: #ddd;
    }

    .line {
      height: 1px;
      background: rgba(255, 255, 255, 0.5);
      margin: 20px 0;
    }

    .create {
      text-align: center;
      font-weight: bold;
      letter-spacing: 1px;
      cursor: pointer;
      color: white;
      text-decoration: none;
    }

    #cmnt{
      margin: 2px;
      color:crimson;
    }


    @media (max-width: 700px) {
      .left-section {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="left-section">
      <div class="logo">

      </div>
      <p class="text">
        ConnectUs

      </p>
      <p>Connect | Chat | Explore</p>
    </div>
    <div class="right-section">
      <form method="post" autocomplete="off">
        <h3>NEW USERNAME</h3>
        <input type="text" placeholder="Create new username" name="Username" required>
        <?php echo "<p id='cmnt'>".$cmnt."</p>"; ?>
        <br>
        <h3>EMAIL</h3>
        <input type="email" placeholder="Enter E-mail" name="Email" required>

        <button type="submit" class="login-btn" name="Next">Next</button>

      </form>
    </div>
  </div>
</body>

</html>