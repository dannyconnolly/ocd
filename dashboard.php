<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

include_once 'includes/layout/header.php';
?>
<div class="large-8 columns">
    <header class="large-8 columns page-head">
        <h1 class="page-title">Dashboard</h1>
    </header>
    <?php if (Session::exists('dashboard')) { ?>
        <div data-alert class="alert-box info radius">
            <?php echo Session::flash('dashboard'); ?>
            <a href="#" class="close">&times;</a>
        </div>
    <?php } ?>
</div>
<div class = "large-4 columns">
    <div class="dw-box">
        <header class="dw-header">
            <h3><span class="fi-torso"></span>Your Profile</h3>
        </header>
        <div class="dw-profile row">
            <div class="large-4 columns">
                <span class="th">
                    <img src="http://foundation.zurb.com/docs/assets/img/examples/space.jpg" width="90px" height="90px">
                </span>
            </div>
            <div class="large-8 columns">
                <h4><?php echo escape($user->data()->name); ?></h4>
                <p><?php echo escape($user->data()->email); ?></p>
            </div>

        </div>
    </div>

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
                <li class="dw-list-item"><a href="<?php echo escape($book->url); ?>" title="<?php echo escape($book->title); ?>" target="_blank"><?php echo escape($book->title); ?></a></li>
                <?php } ?>
        </ul>
    </div>
</div>
<?php include_once 'includes/layout/footer.php'; ?>