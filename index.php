<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dave's Blog | Home</title>
    <link rel="stylesheet" href="style/bootstrap/4.3.1/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css"> -->
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>

    <div id="wrapper" class="container">
        <div class="row">
            <div class="col-sm-12">
            <?php include('mainmenu.php'); ?>               
            </div>
        </div>

        <?php
        try {

            $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
            while ($row = $stmt->fetch()) {

                echo '<div class="row">';
                echo '<div class="col-sm-12">';
                echo '<hr>';
                echo '<h2 class="display-4">' . $row['postTitle'] . '</h2>';
                echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . '</p>';
                echo '<p>' . $row['postDesc'] . '</p>';
                echo '<a href="viewpost.php?id=' . $row['postID'] . '" class="btn btn-outline-info">Read More</a>';
                echo '</div>';
                echo '</div>';
                echo '<br />';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html> 