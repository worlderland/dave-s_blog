<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand display-1" href="./">Dave's Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

        <?php 
        if (!$user->is_logged_in()) {
            echo '<ul class="navbar-nav">';
            echo '<li class="nav-item"><a class="nav-link" href="./admin">Login</a></li>';
            echo '</ul>';
        } else {
            echo '<ul class="nav navbar-nav">';
            echo '<li class="nav-item"><a class="nav-link" href="./admin">Admin</a></li>';
            echo '</ul>';
            echo '<ul class="nav navbar-nav ml-auto">';
            echo '<li class="nav-item"><span class="nav-link text-uppercase">Welcome ' . $_SESSION['username'] . '!</span></li>';
            echo '<li class="nav-item"><a href="./admin/logout.php" class="nav-link">Logout</a></li>';
            echo '</ul>';
        }
        ?>

    </div>
</nav> 