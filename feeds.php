<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

$feed = new Feed();
$feeds = $feed->getAll(Session::getValue(Config::get('session/session_name')));
?>

<div class="large-8 columns">
    <header class="large-8 columns page-head">
        <h1 class="page-title">Feeds</h1>
    </header>

    <div class="large-4 columns">
        <a href="addfeed.php" class="button add">Add feed</a>
    </div>
    <div class="container large-12 columns">
        <?php if (Session::exists('feed')) { ?>
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('feed'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        <?php } ?>
        <dl class="accordion" data-accordion>
            <?php
            $i = 1;
            foreach ($feeds as $item) {
                ?>
                <dd>
                    <a href="#panel<?php echo $i; ?>"><?php echo escape($item->title); ?>
                        <?php
                        if (!empty($item->updated)) {
                            ?>
                            <small>Updated: <?php echo formatDate(escape($item->updated)); ?></small>
                            <?php
                        } else {
                            ?>
                            <small>Created: <?php echo formatDate(escape($item->created)); ?></small>
                            <?php
                        }
                        ?>
                    </a>
                    <div id="panel<?php echo $i; ?>" class="content">
                        <ul class="small-block-grid-3">
                            <?php
                            $rss_items = simplexml_load_file($item->url);

                            foreach ($rss_items->channel->item as $rss_item) {
                                ?>
                                <li>
                                    <div  class="feed-box">
                                        <span class="th">
                                            <img src="" alt="" />
                                        </span>
                                        <h4 class="feed-title"><a href="<?php echo $rss_item->link ?>" title="<?php echo $rss_item->title ?>" class="feed-link" target="_blank"><?php echo $rss_item->title ?></a></h4>
                                        <p><?php echo substr(strip_tags($rss_item->description), 0, 140); ?></p>
                                        <small><?php echo $rss_item->pubDate; ?></small>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </dd>  

                <?php
                $i++;
            }
            ?>
        </dl>

        </ul>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>