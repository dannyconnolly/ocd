<div class="large-12 columns sidebar">

    <?php
    if ($user->isLoggedIn()) {
        ?>   
        <ul class="sidebar-nav row">
            <li class="large-3 columns">
                <a href="categories.php" title="Categories"><span class="fi-folder"></span>Categories</a>
            </li>
            <li class="large-3 columns">
                <a href="feeds.php" title="Bookmarks"><span class="fi-rss"></span>Feeds</a>
            </li>
            <li class="large-3 columns">
                <a href="bookmarks.php" title="Bookmarks"><span class="fi-bookmark"></span>Bookmarks</a>
            </li>
            <li class="large-3 columns">
                <a href="profile.php?user=<?php echo escape($user->data()->username); ?>" title="Bookmarks"><span class="fi-torso"></span>Profile</a>
            </li>  
        </ul>  
        <?php
    } else {
        
    }
    ?>
</div>


