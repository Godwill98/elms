<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['signin']))
{
    $uname=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT EmailId,Password,Status,id FROM tblemployees WHERE EmailId=:uname and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $status=$result->Status;
            $_SESSION['eid']=$result->id;
        }
        if($status==0)
        {
            $msg="Your account is Inactive. Please contact admin";
        } else {
            $_SESSION['emplogin']=$_POST['username'];
            echo "<script type='text/javascript'> document.location = 'emp-changepassword.php'; </script>";
        }
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Employee Home Page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, #1de9b6 0%, #1dc4e9 100%);
        }
        .mn-content {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .page-title h4 {
            margin: 0 0 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .card {
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
        }
        .card-content {
            padding: 20px;
        }
        .card-title {
            margin: 0 0 20px 0;
            font-size: 20px;
            font-weight: bold;
            color: #1dc4e9;
          
        }
        .input-field {
            position: relative;
            margin-bottom: 20px;
        }
        .input-field label {
            position: absolute;
            top: 12px;
            left: 10px;
            font-size: 16px;
            color: #aaa;
            transition: all 0.3s ease;
        }
        .input-field input[type="text"],
        .input-field input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s ease;
            font-size: 16px;
        }
        .input-field input[type="text"]:focus + label,
        .input-field input[type="password"]:focus + label,
        .input-field input[type="text"]:not(:placeholder-shown) + label,
        .input-field input[type="password"]:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #1dc4e9;
        }
        .input-field input[type="text"]:focus,
        .input-field input[type="password"]:focus {
            border-color: #1dc4e9;
            outline: none;
        }
        .btn {
            display: inline-block;
            width: 100%;
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #1de9b6;
            border-radius: 8px;
            color: #fff;
            text-align: center;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .btn:hover {
            background-color: #1dc4e9;
        }
        .errorWrap {
            margin: 20px 0;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 8px;
            text-align: center;
        }
        .additional-links {
            margin-top: 20px;
            text-align: center;
        }
        .additional-links a {
            color: #1dc4e9;
            text-decoration: none;
            font-size: 16px;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .additional-links a:hover {
            color: #1de9b6;
        }
    </style>
</head>
<body>
    <div class="mn-content">
        <div class="page-title">
            <h4>Employee Leave Management System</h4>
        </div>

        <div class="card">
            <div class="card-content">
                <span class="card-title">Employee Login</span>
                <?php if($msg){?><div class="errorWrap"><strong>Error</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                <div class="row">
                    <form class="col s12" name="signin" method="post">
                        <div class="input-field col s12">
                            <input id="username" type="text" name="username" autocomplete="off" required>
                            <label for="username">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" autocomplete="off" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="col s12 right-align m-t-sm">
                            <input type="submit" name="signin" value="Sign in" class="btn">
                        </div>
                    </form>
                </div>
                <div class="additional-links">
                    <a href="forgot-password.php">Forgot Password?</a> | 
                    <a href="admin/">Admin Portal</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>