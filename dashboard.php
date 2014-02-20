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
    <ul class="breadcrumbs">
        <li class="current"><a href="#">Home</a></li>
    </ul>

    <header class="page-head">
        <h1 class="page-title">Dashboard</h1>
    </header>
    <?php if (Session::exists('dashboard')) { ?>
        <div class="large-12 columns">
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('dashboard'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="container large-12 columns">
            <?php
            $feed->saveFeedItems(Session::getValue(Config::get('session/session_name')));

            foreach ($feeds as $item) {
                $rss_items = simplexml_load_file($item->url);
                $count = 0;

                foreach ($rss_items->channel->item as $rss_item) {
                    if ($count == 1) {
                        break;
                    }
                    ?>
                    <article class="feed-box">
                        <header>
                            <h6 class="feed-site">
                                <img src="<?php echo get_favicon($rss_items->channel->link) ?>" width="16" height="16"/>
                                <a href=""><?php echo escape($item->title); ?></a>
                            </h6>
                            <small class="feed-date"><?php echo date('jS F Y, g:i a', strtotime($rss_item->pubDate)); ?></small>
                        </header>
                        <h4 class="feed-title"><a href="<?php echo $rss_item->link ?>" title="<?php echo $rss_item->title ?>" class="feed-link" target="_blank"><?php echo $rss_item->title ?></a></h4>
                        <p><?php echo substr(strip_tags($rss_item->description), 0, 260); ?></p>
                    </article>
                    <?php
                    $count++;
                }
            }
            ?>
            </ul>
        </div>
    </div>
</div>
<div class = "large-4 columns">
    <?php include_once 'includes/layout/profile-widget.php'; ?>
    <?php include_once 'includes/layout/recent-bookmarks.php'; ?>
</div>
<?php include_once 'includes/layout/footer.php'; ?>