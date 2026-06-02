<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $contactno=$_POST['contactno'];
    $email=$_POST['email'];

    $query=mysqli_query($con,"select ID from tbladmin where  Email='$email' and MobileNumber='$contactno' ");
    $ret=mysqli_fetch_array($query);
    if($ret){
      $_SESSION['contactno']=$contactno;
      $_SESSION['email']=$email;
      header('location:reset-password.php');
    }
    else{
      echo "<script>alert('Invalid Details. Please try again.');</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password | Ambullance Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/style.css?v=<?=time()?>" rel='stylesheet' type='text/css' />
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <link href='//fonts.googleapis.com/css?family=Outfit:300,400,600,700' rel='stylesheet' type='text/css'>
    <style>
        body {
            background: url('../assets/img/gallery/Ambulance2.jpg') center center fixed;
            background-size: cover;
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            background-color: #f1f7fd; 
        }
        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #444;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-card h2 {
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 26px;
            color: #2c4964;
        }
        .form-group {
            margin-bottom: 25px;
            position: relative;
            text-align: left;
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3fbbc0;
            font-size: 18px;
        }
        .form-control {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 12px 15px 12px 45px;
            color: #495057;
            height: auto;
            transition: 0.3s;
        }
        .form-control:focus {
            background: #fff;
            border-color: #3fbbc0;
            box-shadow: 0 0 0 0.2rem rgba(63, 187, 192, 0.25);
            color: #495057;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .btn-login {
            background: #3fbbc0;
            border: none;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            font-size: 16px;
            color: #fff;
            margin-top: 10px;
            transition: 0.3s;
            cursor: pointer;
        }
        .btn-login:hover {
            background: #36a5a9;
        }
        .login-footer {
            margin-top: 25px;
            font-size: 14px;
        }
        .login-footer a {
            color: #3fbbc0;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .login-footer a:hover {
            color: #2c4964;
        }
        .back-home {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background: #e9f7f8;
            color: #3fbbc0 !important;
            border-radius: 5px;
            font-size: 13px;
        }
        .back-home:hover {
            background: #3fbbc0;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Forgot Password</h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 25px;">Enter your details to reset your access.</p>
            <form action="#" method="post" name="submit">
                <div class="form-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required="true">
                </div>
                <div class="form-group">
                    <i class="fa fa-phone"></i>
                    <input type="text" class="form-control" name="contactno" placeholder="Mobile Number" required="true">
                </div>
                
                <button type="submit" name="submit" class="btn-login">RESET ACCESS</button>
            </form>
            
            <div class="login-footer">
                <div class="back-links">
                    <a href="login.php" class="secondary-link">
                        <i class="fa fa-arrow-left mr-2"></i> Back to Login
                    </a>
                    <a href="../index.php" class="secondary-link">
                        <i class="fa fa-home mr-2"></i> Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
