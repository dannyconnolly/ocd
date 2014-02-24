<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';
if (Input::get('cid')) {
    $category = new Category(Input::get('cid'));
} else {
    Redirect::to(404);
}
?>

<div class="large-8 columns">

    <ul class="breadcrumbs">
        <li><a href="<?php echo $home = $user->isLoggedIn() ? 'dashboard' : 'index'; ?>.php">Home</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li class="current"><a href="#"><?php echo $category->data()->name; ?></a></li>
    </ul>

    <header class="page-head">
        <h1 class="page-title"><?php echo $category->data()->name; ?></h1>
    </header>

    <div class="row">

        <?php if (Session::exists('category')) { ?>
            <div class="large-12 columns">
                <div data-alert class="alert-box info radius">
                    <?php echo Session::flash('category'); ?>
                    <a href="#" class="close">&times;</a>
                </div>
            </div>
        <?php } ?>
        <div class="large-12">
            <dl class="tabs" data-tab>
                <dd class="active"><a href="#panel2-1">Feeds</a></dd>
                <dd><a href="#panel2-2">Bookmarks</a></dd>
            </dl>
            <div class="tabs-content">
                <div class="content active" id="panel2-1">
                    <?php
                    $feed = new Feed();
                    $feeds = $feed->feedStream(Input::get('cid'));
                    ?>
                    <?php
                    if ($feeds) {
                        foreach ($feeds as $item) {
                            ?>
                            <article class="feed-box">
                                <header>
                                    <h6 class="feed-site"><img src="<?php echo get_favicon($item->link) ?>" width="16" height="16"/><a href=""><?php echo escape($item->name); ?></a></h6>
                                    <small class="feed-date"><?php echo date('jS F Y, g:i a', strtotime($item->pub_date)); ?></small>
                                </header>
                                <h4 class="feed-title"><a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>" class="feed-link" target="_blank"><?php echo $item->title ?></a></h4>
                                <p><?php echo substr(strip_tags($item->content), 0, 260); ?></p>
                            </article>
                            <?php
                        }
                    } else {
                        ?>
                        <p>No feeds for this category</p>
                        <?php
                    }
                    ?>
                </div>
                <div class="content" id="panel2-2">
                    <!-- Bookmarks go here -->
                    <?php
                    $bookmark = new Bookmark();
                    $bookmarks = $bookmark->getAllByCategory(Input::get('cid'));
                    if ($bookmarks) {
                        foreach ($bookmarks as $book) {
                            ?>
                            <article class="bookmark-box">
                                <h4>
                                    <a href="<?php echo escape($book->url); ?>" title="<?php echo escape($book->title); ?>" target="_blank"><img src="<?php echo get_favicon(escape($book->url)) ?>" width="16" height="16"/><?php echo escape($book->title); ?></a>
                                </h4>
                            </article>
                            <?php
                        }
                    } else {
                        ?>
                        <p>No bookmarks for this category</p>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>