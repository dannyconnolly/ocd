<?php
require_once 'core/init.php';
$user = new User();

$feed = new Feed();
$feeds = $feed->getAll(Session::getValue(Config::get('session/session_name')));

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

include_once 'includes/layout/header.php';
?>
<div class="large-8 columns">
    <?php if (Session::exists('dashboard')) { ?>
        <div class="large-12 columns">
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('dashboard'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        </div>
    <?php } ?>
    <ul class="breadcrumbs">
        <li class="current"><a href="#">Home</a></li>
    </ul>

    <header class="page-head">
        <h1 class="page-title">Dashboard</h1>
    </header>
    <div class="row">
        <div class="container large-12 columns">
            <?php
            $feed->saveFeedItems(Session::getValue(Config::get('session/session_name')));
            $feeds = $feed->allFeedStream();

            if (!empty($feeds)) {
                foreach ($feeds as $item) {
                    ?>
                    <article class="feed-box">
                        <header>
                            <h6 class="feed-site">
                                <img src="<?php echo get_favicon($item->link) ?>" width="16" height="16"/>
                                <a href=""><?php echo escape($item->name); ?></a>
                            </h6>
                            <small class="feed-date"><?php echo date('jS F Y, g:i a', strtotime($item->pub_date)); ?></small>
                        </header>
                        <h4 class="feed-title"><a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>" class="feed-link" target="_blank"><?php echo $item->title ?></a></h4>
                        <p><?php echo substr(strip_tags($item->content), 0, 260); ?></p>
                    </article>
                    <?php
                }
            } else {
                ?>
                <p>Click <a href="addfeed.php">here</a> to add a feed</p>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class = "large-4 columns">
    <?php include_once 'includes/layout/profile-widget.php'; ?>
    <?php include_once 'includes/layout/recent-bookmarks.php'; ?>
</div>
<?php include_once 'includes/layout/footer.php'; ?>
