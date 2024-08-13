<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Initialize variables for employee ID and email
$empid = '';
$email = '';

// Code for changing password
if (isset($_POST['change'])) {
    $newpassword = md5($_POST['newpassword']);
    $empid = $_SESSION['empid'];

    $con = "UPDATE tblemployees SET Password=:newpassword WHERE id=:empid";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':empid', $empid, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    $msg = "Your Password has been successfully changed";
    // Clear session data after password change
    unset($_SESSION['empid']);
}

// Display the password change form only if the employee ID and email are validated.
if (isset($_POST['submit'])) {
    $empid = $_POST['empid'];
    $email = $_POST['emailid'];

    $sql = "SELECT id FROM tblemployees WHERE EmailId=:email AND EmpId=:empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['empid'] = $result->id;
        }
        $showChangePasswordForm = true;
    } else {
        $error = "Invalid details";
    }
} else {
    $showChangePasswordForm = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>ELMS | Password Recovery</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    
    <!-- Materialize CSS -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">        
    <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #1de9b6 0%, #1dc4e9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            
        }
        .card-title {
            font-size: 20px;
            color: #1dc4e9;
            text-align: center;
        }
        .input-field label {
            font-size: 14px;
            color: #1dc4e9;
            top: -10px; /* Adjust this value to align with input fields */
            left: 0;
        }
        .input-field .helper-text {
            font-size: 12px;
            color: #f44336;
        }
        .btn {
            background-color: #1dc4e9;
            color: #fff;
            width: 100%;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            text-transform: uppercase;
           
        }
        .btn:hover {
            background-color: #1de9b6;
        }
        .errorWrap, .succWrap {
            margin: 20px 0;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
        }
        .errorWrap {
            background-color: #f44336;
            color: #fff;
        }
        .succWrap {
            background-color: #5cb85c;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="card">
                    <span class="card-title">Employee Password Recovery</span>
                    <?php if ($msg) { ?>
                        <div class="succWrap"><strong>Success:</strong> <?php echo htmlentities($msg); ?></div>
                    <?php } ?>
                    <?php if ($error) { ?>
                        <div class="errorWrap"><strong>Error:</strong> <?php echo htmlentities($error); ?></div>
                    <?php } ?>
                    
                    <?php if (!$showChangePasswordForm) { ?>
                        <form name="signin" method="post">
                            <div class="input-field">
                                <input id="empid" type="text" name="empid" required>
                                <label for="empid">Employee ID</label>
                            </div>
                            <div class="input-field">
                                <input id="emailid" type="email" name="emailid" required>
                                <label for="emailid">Email</label>
                            </div>
                            <button type="submit" name="submit" class="btn">Submit</button>
                        </form>
                    <?php } else { ?>
                        <div class="card">
                            <span class="card-title">Change Your Password</span>
                            <form name="udatepwd" method="post">
                                <div class="input-field">
                                    <input id="newpassword" type="password" name="newpassword" required>
                                    <label for="newpassword">New Password</label>
                                </div>
                                <div class="input-field">
                                    <input id="confirmpassword" type="password" name="confirmpassword" required>
                                    <label for="confirmpassword">Confirm Password</label>
                                </div>
                                <button type="submit" name="change" class="btn">Change Password</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="assets/js/alpha.min.js"></script>
</body>
</html>
