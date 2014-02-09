<div class="dw-box">
    <header class="dw-header">
        <h3><span class="fi-bookmark"></span>Recent Bookmarks</h3>
    </header>
    <ul class="dw-list">
        <?php
        $bookmark = new Bookmark();
        $bookmarks = $bookmark->getRecentBookmarks(Session::getValue(Config::get('session/session_name')));

        foreach ($bookmarks as $book) {
            ?>
            <li class="dw-list-item">
                <a href="<?php echo escape($book->url); ?>" title="<?php echo escape($book->title); ?>" target="_blank">
                    <img src="<?php echo get_favicon(escape($book->url)); ?>" width="16" height="16"/>
                    <?php echo escape($book->title); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>