<?php

include("./php/connection.php");
include("./api/sanitization.php");
include("./php/functions.php");

$incpass = 0;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  //something was posted
  $fields=[
    'user_name'=>'email',
    'password'=>'string'
  ];
  $data=sanitize($_POST,$fields);
  $user_name = $data['user_name'];
  $password = $data['password'];
  if (!empty($user_name) && !empty($password)) {
    
    //read from database
    $query = "select * from auth where email = '$user_name' limit 1";
    $result = mysqli_query($con, $query);
    if ($result) {
      if ($result && mysqli_num_rows($result) > 0) {

        $user_data = mysqli_fetch_assoc($result);
        if (password_verify($password, $user_data['pass'])) {

          $_SESSION['uid'] = $user_data['uid'];
          header("Location: index.php");
          die;
        }
      }
    }

    $incpass = 1;
  } else {
    $incpass = 1;
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/16d37616d9.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Martel&family=Montserrat:wght@500&family=Yantramanav:wght@500&display=swap" rel="stylesheet">
  <style>
    @import url('https://rsms.me/inter/inter-ui.css');

    ::selection {
      background: #2D2F36;
    }

    ::-webkit-selection {
      background: #2D2F36;
    }

    ::-moz-selection {
      background: #2D2F36;
    }

    body {
      background: white;
      font-family: 'Montserrat', sans-serif !important;
      margin: 0;
      height: 100%;
      width: 100%;

    }

    html {
      height: 100%;
      width: 100%;

    }

    .page {
      display: flex;
      flex-direction: column;
      padding-left: 30px;
      height: calc(100% - 40px);
      position: absolute;
      place-content: center;
      width: calc(100% - 40px);
    }

    @media (max-width: 767px) {
      .page {
        height: auto;
        margin-bottom: 20px;
        padding-bottom: 20px;
      }
    }

    .container {
      display: flex;
      height: 320px;
      margin: 0 auto;
      width: 640px;
    }

    @media (max-width: 767px) {
      .container {
        flex-direction: column;
        height: 630px;
        width: 320px;
      }
    }

    .left {
      background: white;
      height: calc(100% - 40px);
      top: 20px;
      position: relative;
      width: 50%;
    }

    @media (max-width: 767px) {
      .left {
        height: 100%;
        left: 20px;
        width: calc(100% - 40px);
        max-height: 270px;
      }
    }

    .login {
      font-size: 50px;
      font-weight: 900;
      margin: 50px 40px 40px;
    }

    .eula {
      color: #000000b3;
      font-size: 14px;
      line-height: 1.5;
      margin: 20px;
    }

    .right {
      background: #2494db;
      box-shadow: 0px 0px 40px 16px rgba(0, 0, 0, 0.22);
      color: #F1F1F2;
      position: relative;
      width: 50%;
    }

    @media (max-width: 767px) {
      .right {
        flex-shrink: 0;
        height: 100%;
        width: 100%;
        max-height: 350px;
      }
    }

    svg {
      position: absolute;
      width: 320px;
    }

    path {
      fill: none;
      stroke: url(#linearGradient);
      ;
      stroke-width: 4;
      stroke-dasharray: 240 1386;
    }

    .form {
      margin: 40px;
      position: absolute;
    }

    label {
      display: block;
      font-size: 14px;
      height: 16px;
      margin-top: 20px;
      margin-bottom: 5px;
    }

    input {
      background: #5eacde;
      border: 0;
      border-radius: 20px;
      color: #f2f2f2;
      font-size: 15px;
      padding: 10px;
      height: 30px;
      line-height: 30px;
      outline: none !important;
      width: 100%;
    }

    input::-moz-focus-inner {
      border: 0;
    }

    #submit {
      color: #f2f2f2;
      width: max-content;
      transition: color 300ms;
      justify-content: center;
      margin: 25px auto;
      display: block;
      padding-top: 0;
    }

    #submit:focus {
      color: #f2f2f2;
    }

    #submit:active {
      color: #d0d0d2;
    }
  </style>

</head>

<body>
  <div id="noty-holder" style="position: absolute;width: 100%;z-index: 2;text-align:center"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #2494db;width:100%">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: larger;font-weight:bold">
          <li class="nav-item">
            <a class="navbar-brand" id="Login" href="#">Admin Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <center>
    <div id="preloader" class="fa-3x" style="padding-top:20%">
      <i class="fa-solid fa-cog fa-spin"></i>
    </div>
  </center>

  <div class="page">
    <div class="container">
      <div class="left">
        <table>

          <tr>

          </tr>
        </table>
        <h1 style="text-align:center"><br> Portal</h1>
        <div style="text-align:center" class="eula"> Login</div>
      </div>
      <div class="right">
        <div class="form">
          <form method="post">
            <label for="user_name">Email</label>
            <input id="email" type="text" name="user_name"><br>
            <label for="password">Password</label>
            <input id="password" type="password" name="password"><br><br>
            <input type="submit" id="submit" style="align" value="Login">
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    var current = null;
    document.querySelector('#email').addEventListener('focus', function(e) {
      if (current) current.pause();
      current = anime({
        targets: 'path',
        strokeDashoffset: {
          value: 0,
          duration: 700,
          easing: 'easeOutQuart'
        },
        strokeDasharray: {
          value: '240 1386',
          duration: 700,
          easing: 'easeOutQuart'
        }
      });
    });
    document.querySelector('#password').addEventListener('focus', function(e) {
      if (current) current.pause();
      current = anime({
        targets: 'path',
        strokeDashoffset: {
          value: -336,
          duration: 700,
          easing: 'easeOutQuart'
        },
        strokeDasharray: {
          value: '240 1386',
          duration: 700,
          easing: 'easeOutQuart'
        }
      });
    });
    document.querySelector('#submit').addEventListener('focus', function(e) {
      if (current) current.pause();
      current = anime({
        targets: 'path',
        strokeDashoffset: {
          value: -730,
          duration: 700,
          easing: 'easeOutQuart'
        },
        strokeDasharray: {
          value: '530 1386',
          duration: 700,
          easing: 'easeOutQuart'
        }
      });
    });
  </script>
  <script>
    var loader = document.getElementById("preloader");
    window.addEventListener("load", function() {
      loader.style.display = "none";
      <?php if ($incpass == 1) {
      ?>
        createNoty("Incorrect UserId or Password", 'danger');
      <?php
      } ?>
    })
  </script>
</body>

</html>