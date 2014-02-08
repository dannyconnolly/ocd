<?php
require_once 'core/init.php';
$user = new User();

$feed = new Feed();
$feeds = $feed->getAll();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

include_once 'includes/layout/header.php';
?>
<div class="large-8 columns">
    <header class="dw-header">
        <h1><span class="fi-widget"></span>Dashboard</h1>
    </header>
    <?php if (Session::exists('dashboard')) { ?>
        <div data-alert class="alert-box info radius">
            <?php echo Session::flash('dashboard'); ?>
            <a href="#" class="close">&times;</a>
        </div>
    <?php } ?>
    <div class="container">
        <ul class="feed-list">
            <?php
            foreach ($feeds as $item) {
                $rss_items = simplexml_load_file($item->url);
                $count = 0;

                foreach ($rss_items->channel->item as $rss_item) {
                    if ($count == 1) {
                        break;
                    }
                    ?>
                    <li data-date="<?php echo date('d-m-y', strtotime($rss_item->pubDate)); ?>">
                        <div class="feed-box">
                            <small><?php echo date('jS F Y, g:i a', strtotime($rss_item->pubDate)); ?></small>
                            <h4 class="feed-title"><a href="<?php echo $rss_item->link ?>" title="<?php echo $rss_item->title ?>" class="feed-link" target="_blank"><?php echo $rss_item->title ?></a></h4>
                            <h6 class="feed-site"><?php echo escape($item->title); ?></h6>
                            <p><?php echo substr(strip_tags($rss_item->description), 0, 140); ?></p>
                        </div>
                    </li>
                    <?php
                    $count++;
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class = "large-4 columns">
    <div class="dw-box">
        <header class="dw-header">
            <h3><span class="fi-torso"></span>Your Profile</h3>
        </header>
        <div class="dw-profile row">
            <div class="large-4 columns dw-gravatar">
                <span class="th">
                    <img src="<?php echo $user->get_gravatar(escape($user->data()->email)); ?>" alt="<?php echo escape($user->data()->name); ?>" />
                </span>
            </div>
            <div class="large-8 columns dw-profile-text">
                <h4><?php echo escape($user->data()->name); ?></h4>
                <p><?php echo escape($user->data()->email); ?></p>
                <a href="update.php" title="edit profile">Edit profile</a>
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