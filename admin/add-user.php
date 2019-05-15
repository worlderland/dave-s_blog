<?php  //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dave's Blog | Add User</title>
    <link rel="stylesheet" href="../style/bootstrap/4.3.1/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css"> -->
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
			<?php include('admintopmenu.php'); ?>
            </div>
        </div>
        <br />
        <hr>

        <?php include('menu.php'); ?>
        <!-- <p><a href="users.php">User Admin Index</a></p> -->

        <h2 class="display-4">Add User</h2>

        <?php

		//if form has been submitted process it
		if (isset($_POST['submit'])) {

			//collect form data
			extract($_POST);

			//very basic validation
			if ($username == '') {
				$error[] = 'Please enter the username.';
			}

			if ($password == '') {
				$error[] = 'Please enter the password.';
			}

			if ($passwordConfirm == '') {
				$error[] = 'Please confirm the password.';
			}

			if ($password != $passwordConfirm) {
				$error[] = 'Passwords do not match.';
			}

			if ($email == '') {
				$error[] = 'Please enter the email address.';
			}

			if (!isset($error)) {

				$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

				try {

					//insert into database
					$stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)');
					$stmt->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email
					));

					//redirect to index page
					header('Location: users.php?action=added');
					exit;
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
		}

		//check for any errors
		if (isset($error)) {
			foreach ($error as $error) {
				echo '<p class="error">' . $error . '</p>';
			}
		}
		?>

        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input for="username" class="form-control" type="text" name="username" value="<?php if (isset($error)) {
																									echo $_POST['username'];
																								} ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" class="form-control" type="password" name="password" value="<?php if (isset($error)) {
																										echo $_POST['password'];
																									} ?>">
            </div>
            <div class="form-group">
                <label for="passwordConfirm">Confirm Password</label><br />
                <input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" value="<?php if (isset($error)) {
																													echo $_POST['passwordConfirm'];
																												} ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label><br />
                <input id="email" class="form-control" type="text" name="email" value="<?php if (isset($error)) {
																							echo $_POST['email'];
																						} ?>">
            </div>
            <input type="submit" name="submit" value="Add User" class="btn btn-outline-info">
        </form>
        <br />
    </div> 