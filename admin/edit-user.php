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
    <title>Dave's Blog | Edit User</title>
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

        <h2 class="display-4">Edit User</h2>


        <?php

		//if form has been submitted process it
		if (isset($_POST['submit'])) {

			//collect form data
			extract($_POST);

			//very basic validation
			if ($username == '') {
				$error[] = 'Please enter the username.';
			}

			if (strlen($password) > 0) {

				if ($password == '') {
					$error[] = 'Please enter the password.';
				}

				if ($passwordConfirm == '') {
					$error[] = 'Please confirm the password.';
				}

				if ($password != $passwordConfirm) {
					$error[] = 'Passwords do not match.';
				}
			}


			if ($email == '') {
				$error[] = 'Please enter the email address.';
			}

			if (!isset($error)) {

				try {

					if (isset($password)) {

						$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

						//update into database
						$stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email WHERE memberID = :memberID');
						$stmt->execute(array(
							':username' => $username,
							':password' => $hashedpassword,
							':email' => $email,
							':memberID' => $memberID
						));
					} else {

						//update database
						$stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email WHERE memberID = :memberID');
						$stmt->execute(array(
							':username' => $username,
							':email' => $email,
							':memberID' => $memberID
						));
					}


					//redirect to index page
					header('Location: users.php?action=updated');
					exit;
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
		}

		?>


        <?php
	//check for any errors
		if (isset($error)) {
			foreach ($error as $error) {
				echo $error . '<br />';
			}
		}

		try {

			$stmt = $db->prepare('SELECT memberID, username, email FROM blog_members WHERE memberID = :memberID');
			$stmt->execute(array(':memberID' => $_GET['id']));
			$row = $stmt->fetch();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		?>

        <form action="" method="post">
            <input type="hidden" name="memberID" value="<?php echo $row['memberID']; ?>">
            <div class="form-group">
                <label for="username">Username</label><br />
                <input id="username" class="form-control" type="text" name="username" value="<?php echo $row['username']; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password (only to change)</label>
                <input id="password" class="form-control" type="password" name="password" value="">
            </div>
            <div class="form-group">
                <label for="passwordConfirm">Confirm Password</label>
                <input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" value="">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>">
            </div>
            <input type="submit" name="submit" value="Update User" class="btn btn-outline-info">
        </form>
        <br />
    </div>

</body>

</html> 