<?php
session_start();

include("config.php");


if (isset($_POST['Finish'])) {
    if ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/jpg' || $_FILES['photo']['type'] == 'image/png') {
        print_r($_FILES['photo']);
        $fname = $_FILES['photo']['name'];
        $fsize = $_FILES['photo']['size'];
        $ftmp = $_FILES['photo']['tmp_name'];

        $use = $_SESSION['UserName'];
        $uid = $_SESSION['UID'];
        $fpath = './Uploads/';
        $src = $fpath."Prof" . $use . $uid . $fname;
        move_uploaded_file($ftmp, $src);


        $bio = $_POST['bio'];

        $_SESSION['bio'] = $bio;
        $_SESSION['Profile_picture'] = $src;


$sql="UPDATE users SET Profile_picture='$src',bio='$bio' WHERE UserId=$uid;";
$conn->query($sql);
header("location:Home.php");

    } else {
        $msg = 'Invalid File Type';
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

        textarea {
            margin-top: 10px;
            resize: none;
            height: 100px;
            border-radius: 12px;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            outline: none;
            width: 100%;
            color: white;
            background: transparent;
            transition: all 0.2s ease;
        }


        #photo {
            margin-top: 20px;
            height: 180px;
            width: 65%;
            margin-left: 55px;
            border-radius: 50%;
            /* background: #000; */
            border: 2px solid white;
            cursor: pointer;
            font-size: 50px;
            text-align: center;
            line-height: 180px;
        }

        h3 {
            margin-top: 30px;
        }

        input[type='file'] {
            display: none;
        }


        @media (max-width: 700px) {
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
            <h3>ENTER YOUR DETAILS </h3>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div id="photo">+</div>
                <input type="file" id="upld" name="photo" accept="image/*" required>
                <h3 class="msg"><?php if (isset($_POST['Finish']))
                    echo $msg; ?></h3>

                <h4>Bio:</h4>
                <textarea name="bio" id="bio"></textarea>

                <input type="submit" value="Finish" name="Finish" class="login-btn">
                <!-- <button type="submit" class="login-btn" name="Create" disabled>Create</button> -->

            </form>
        </div>
    </div>
    <script>

        document.getElementById('photo').addEventListener('click', function () {
            document.getElementById('upld').click();
        });

        //  document.getElementById('upld').addEventListener('change', (event) => {
        //   const file = event.target.files[0];
        //   if (file) {
        //    document.getElementById('photo').innerText="✔";
        //   }
        // });
    </script>

</body>

</html>