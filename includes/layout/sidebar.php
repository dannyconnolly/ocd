<div class="large-1 columns sidebar">
    
<?php
if($user->isLoggedIn()){
    if($user->hasPermission('admin')){ ?>   
      <ul class="sidebar-nav">
        <li>
            <a href="categories.php" title="Categories"><span class="fi-folder"></span>Categories</a>
        </li>
        <li>
            <a href="feeds.php" title="Bookmarks"><span class="fi-rss"></span>Feeds</a>
        </li>
        <li>
            <a href="bookmarks.php" title="Bookmarks"><span class="fi-bookmark"></span>Bookmarks</a>
        </li>
        <li>
            <a href="bookmarks.php" title="Bookmarks"><span class="fi-bookmark"></span>Bookmarks</a>
        </li>
        <li>
            <a href="bookmarks.php" title="Bookmarks"><span class="fi-bookmark"></span>Bookmarks</a>
        </li>    
    </ul>  
<?php    }
} else {
    
}
?>
</div>


