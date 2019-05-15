<?php
 //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->is_logged_in()) {
    header('Location: login.php');
}

//show message from add / edit page
if (isset($_GET['delpost'])) {

    $stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID');
    $stmt->execute(array(':postID' => $_GET['delpost']));

    header('Location: index.php?action=deleted');
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dave's Blog | Admin Portal</title>
    <link rel="stylesheet" href="../style/bootstrap/4.3.1/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css"> -->
    <link rel="stylesheet" href="../style/styles.css">
    <script language="JavaScript" type="text/javascript">
        function delpost(id, title) {
            if (confirm("Are you sure you want to delete '" + title + "'")) {
                window.location.href = 'index.php?delpost=' + id;
            }
        }
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

        <?php 
        //show message from add / edit page
        if (isset($_GET['action'])) {
            echo '<h3 class="display-4">Post ' . $_GET['action'] . '.</h3>';
        }
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID #</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
                    while ($row = $stmt->fetch()) {

                        echo '<tr>';
                        echo '<td>' . $row['postID'] . '</td>';
                        echo '<td>' . $row['postTitle'] . '</td>';
                        echo '<td>' . $row['postDesc'] . '</td>';
                        echo '<td>' . date('jS M Y', strtotime($row['postDate'])) . '</td>';
                        ?>

                <td>
                    <a href="edit-post.php?id=<?php echo $row['postID']; ?>" class="btn btn-warning">Edit</a>
                    <a href="javascript:delpost('<?php echo $row['postID']; ?>','<?php echo $row['postTitle']; ?>')" class="btn btn-danger">Delete</a>
                </td>

                <?php 
                echo '</tr>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
            </tbody>
        </table>

        <a href='add-post.php' class="btn btn-outline-info">Add Post</a>
        <br />
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html> 