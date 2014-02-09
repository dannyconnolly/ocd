<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CRM</title>
        <link href='http://fonts.googleapis.com/css?family=Montserrat+Alternates:400,700|Bevan' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css" />
        <link rel="stylesheet" href="css/app.css" />
        <script src="js/modernizr.js"></script>
    </head>
    <body>

        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a href="index.php"><strong>O.C.D</strong></a></h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
            </ul>

            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    <?php
                    $user = new User();
                    if ($user->isLoggedIn()) {
                        ?>
                        <li class="has-dropdown">
                            <a href="#"><?php echo escape($user->data()->username); ?></a>
                            <ul class="dropdown">
                                <li><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">View profile</a></li>
                                <li><a href="update.php">Update profile</a></li>
                                <li><a href="changepassword.php">Change password</a></li>
                            </ul>
                        </li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php } else { ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php } ?>
                </ul>
                <!-- Left Nav Section -->
                <ul class="left">
                    <li><a href="<?php echo $home = $user->isLoggedIn() ? 'dashboard' : 'index'; ?>.php">Home</a></li>
                    <?php if ($user->isLoggedIn()) { ?>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="bookmarks.php">Bookmarks</a></li>
                        <li><a href="feeds.php">Feeds</a></li>
                    <?php } ?>
                </ul>
            </section>
        </nav>
        <?php
        if ($user->isLoggedIn()) {
            include_once 'includes/layout/sidebar.php';
        }
        ?>
        <div class="large-10 columns content" data-equalizer-watch>