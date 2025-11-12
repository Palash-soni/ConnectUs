<?php
session_start();

include("config.php");

if(isset($_SESSION['UserName'])){
   header("location:Home.php");
}



if (isset($_POST['Login'])) {
    $UserName = $_POST['Username'];
    $Password= $_POST['Password'];

    $sql = "SELECT UserId,UserName,Email,Password,Profile_picture,bio,created_at,website FROM users WHERE BINARY UserName='$UserName' AND Password='$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $UID = $row["UserId"];
            $Profile_pic = $row["Profile_picture"];
            $Email = $row["Email"];
            $bio = $row["bio"];
            $create_at = $row["create_at"];
            $website=$row['website'];
        }
        $_SESSION['UID'] = $UID;
        $_SESSION['Email'] = $Email;
        $_SESSION['Profile_picture'] = $Profile_pic;
        $_SESSION['create_at'] = $create_at;
        $_SESSION['UserName'] = $UserName;
        $_SESSION['Password'] = $Password;
        $_SESSION['bio'] = $bio;
        $_SESSION['Website'] = $website;

       

        header("location:Home.php");
    } else {


        $msg = "Invalid UserName or Password";
    }
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="shortcut icon" href="./Assets/Logo.jpeg" type="image/x-icon"> -->
     <?php include("LinkConfig.php");?>
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

.left-section, .right-section {
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
    
.msg{
  
  text-align: center;
  margin-top: 20px;
  color:red;
  
}





@media (max-width: 700px) {
  .left-section{
    display: none;
  }
}
    </style>
</head>




<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">

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
        <h3>USERNAME</h3>
        <input type="text" placeholder="Enter username" name="Username" required>
        <h3>PASSWORD</h3>
        <input type="password" placeholder="Enter password" name="Password" required>
        <a class="forgot" href="#">
            Forgot Password ?
        </a>
        <button type="submit" class="login-btn" name="Login">LOGIN</button>
        <?php if (isset($_POST['Login'])) echo "<h3 class='msg'>$msg</h3>"?>
        <div class="line"></div>
        <a class="create" href="CreateUser.php">CREATE NEW USER</a>
    </form>
    </div>
    </div>

  <script type="text/javascript">
    window.history.forward();
    function noBack()
    {
        window.history.forward();
    }
</script>
</body>
</html>


