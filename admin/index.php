<?php
session_start();
include('includes/config.php');
if(isset($_POST['signin']))
{
    $uname=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        $_SESSION['alogin']=$_POST['username'];
        echo "<script type='text/javascript'> document.location = 'changepassword.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Simlaw Leave Management System</title>
       
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">        
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Roboto', sans-serif;
        }
        .signin-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1de9b6 0%, #1dc4e9 100%);
           
        .mn-inner  {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .mn-inner:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .subtitle {
            text-align: center;
            font-size: 16px;
            margin-bottom: 30px;
            color: #666;
        }
        .subtitle a {
            color: #1dc4e9;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .subtitle a:hover {
            color: #1de9b6;
        }
        .input-field input[type="text"],
        .input-field input[type="password"] {
            font-size: 14px;
            padding: 12px;
            border-radius: 8px;
            border: 3px solid #ddd;
            margin-bottom: 25px;
            transition: border-color 0.3s ease;
        }
        .input-field input[type="text"]:focus,
        .input-field input[type="password"]:focus {
            border-color: #1de9b6;
            outline: none;
        }
        .custom-btn {
            width: 100%;
            padding: 14px;
            font-size: 18px;
            font-weight: 600;
          
            letter-spacing: 1px;
            background-color: #1de9b6;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            transition: background-color 0.3s ease, transform 0.3s ease;
            color: #fff;
            text-align: center;
        }
        .custom-btn:hover {
            background-color: #1dc4e9;
            transform: translateY(-3px);
        }
        .custom-btn:focus {
            outline: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }
        .custom-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="signin-page">
    <div class="mn-content valign-wrapper">
        <main class="mn-inner container">
            <h4 class="title">Simlaw Leave Management System</h4>
            <h4 class="subtitle"><a href="../index.php">Employee Login portal</a></h4>
            <div class="valign">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <form class="col s12" name="signin" method="post">
                                        <div class="input-field col s12">
                                            <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                            <label for="username">Username/email</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col s12 right-align m-t-sm">
                                            <input type="submit" name="signin" value="Sign in" class="custom-btn">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
</body>
</html>
