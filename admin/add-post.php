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
    <title>Dave's Blog | Add Post</title>
    <link rel="stylesheet" href="../style/bootstrap/4.3.1/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css"> -->
    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
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
        <!-- <p><a href="./">Blog Admin Index</a></p> -->

        <h2 class="display-4">Add Post</h2>

        <?php

        //if form has been submitted process it
        if (isset($_POST['submit'])) {

            $_POST = array_map('stripslashes', $_POST);

            //collect form data
            extract($_POST);

            //very basic validation
            if ($postTitle == '') {
                $error[] = 'Please enter the title.';
            }

            if ($postDesc == '') {
                $error[] = 'Please enter the description.';
            }

            if ($postCont == '') {
                $error[] = 'Please enter the content.';
            }

            if (!isset($error)) {

                try {

                    //insert into database
                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate) VALUES (:postTitle, :postDesc, :postCont, :postDate)');
                    $stmt->execute(array(
                        ':postTitle' => $postTitle,
                        ':postDesc' => $postDesc,
                        ':postCont' => $postCont,
                        ':postDate' => date('Y-m-d H:i:s')
                    ));

                    //redirect to index page
                    header('Location: index.php?action=added');
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
                <label for="postTitle">Title</label>
                <input id="postTitle" class="form-control" type="text" name="postTitle" value="<?php if (isset($error)) {
                                                                                                    echo $_POST['postTitle'];
                                                                                                } ?>">
            </div>
            <div class="form-group">
                <label for="postDesc">Description</label>
                <textarea id="postDesc" class="form-control" name="postDesc" cols="10" rows="1" maxlength="20"><?php if (isset($error)) {
                                                                                                                    echo $_POST['postDesc'];
                                                                                                                } ?></textarea>
            </div>
            <div class="form-group">
                <label for="postCont">Content</label>
                <textarea id="postCont" class="form-control" name="postCont" cols="60" rows="10"><?php if (isset($error)) {
                                                                                                        echo $_POST['postCont'];
                                                                                                    } ?></textarea>
            </div>

            <input type="submit" name="submit" value="Submit" class="btn btn-outline-info">

        </form>
        <br />

    </div> 