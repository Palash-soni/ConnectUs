<?php
session_start();

include("config.php");


if (isset($_POST['Create'])) {
  $Password = $_POST['Password'];
  $Re_Password = $_POST['RePassword'];
  if ($Password == $Re_Password) {
    $username = $_GET['username'];
    $email = $_GET['email'];


    $sql = "INSERT INTO users (UserName,Email,Password) values ('$username','$email','$Password');";
    $conn->query($sql);


    $sql = "SELECT UserId,UserName,Email,Password,created_at FROM users WHERE BINARY UserName='$username' AND Password='$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $UID = $row["UserId"];


        $create_at = $row["create_at"];
      }
      $_SESSION['UID'] = $UID;
      $_SESSION['Email'] = $email;
      $_SESSION['create_at'] = $create_at;
      $_SESSION['UserName'] = $username;
      $_SESSION['Password'] = $Password;



      header("location:Prof_Bio.php");

    }
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

    .msg {

      text-align: center;
      margin-top: 20px;
      color: red;

    }

    .eye {
      position: relative;
      bottom: 50px;
      left: 270px;
      font-size: 18px;
    }


    @media (max-width: 600px) {
  .left-section{
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
        <h3>ENTER PASSWORD</h3>
        <input type="password" placeholder="Enter Your Password" name="Password" id="pass" required>
        <div class="eye"><i class="fa-regular fa-eye"></i></div>
        <h3>CONFIRM PASSWORD</h3>
        <input type="text" placeholder="Re-Enter Password" name="RePassword" id="re_pass" required>

        <input type="submit" value="Create" name="Create" class="login-btn">
        <!-- <button type="submit" class="login-btn" name="Create" disabled>Create</button> -->

      </form>
      <h3 class="msg"></h3>
    </div>
  </div>

  <script>
    let re_pass = document.querySelector("#re_pass");
    let btn = document.querySelector(".login-btn");
    let msgbox = document.querySelector(".msg");
    let pass = document.querySelector("#pass");
    re_pass.addEventListener("input", () => {
      if (pass.value != re_pass.value) {
        msgbox.innerText = "Password Should Be Same";
        btn.disabled = true;
        btn.style.backgroundColor = "gray";
        btn.style.color = "white";
      } else {
        msgbox.innerText = "";
        btn.style.color = "black";
        btn.style.backgroundColor = "white";
        btn.disabled = false;
      }
    });

    let i = true;
    let eye = document.querySelector(".eye");
    eye.addEventListener("click", () => {
      if (i) {
        eye.innerHTML = "<i class='fa-regular fa-eye-slash'></i>";
        pass.type = "text";
        i = false;
      } else {
        eye.innerHTML = "<i class='fa-regular fa-eye'></i>";
        pass.type = "password";
        i = true;
      }
    });



  </script>
</body>

</html>