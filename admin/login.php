<?php
 //include config
require_once('../includes/config.php');


//check if already logged in
if ($user->is_logged_in()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dave's Blog | Home</title>
    <link rel="stylesheet" href="../style/bootstrap/4.3.1/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css"> -->
    <link rel="stylesheet" href="../style/styles.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <?php include('admintopmenu.php'); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div id="login" class="col-sm-12">

                <?php

                //process login form if submitted
                if (isset($_POST['submit'])) {

                    $username = trim($_POST['username']);
                    $password = trim($_POST['password']);

                    if ($user->login($username, $password)) {

                        //logged in return to index page
                        header('Location: index.php');
                        exit;
                    } else {
                        $message = '<p class="text-danger display-4">Wrong username or password</p>';
                    }
                } //end if submit

                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="userName">Username</label>
                        <input id="userName" type="text" name="username" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Password1">Password</label>
                        <input id="Password1" type="password" name="password" value="" class="form-control">
                    </div>
                    <input type="submit" name="submit" value="Login" class="btn btn-outline-info">
                </form>

            </div>
        </div>
    </div>
</body>

</html> 