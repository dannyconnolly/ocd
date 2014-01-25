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
    <header class="large-8 columns page-head">
        <h1 class="page-title"><?php echo $category->data()->name; ?></h1>
    </header>

    <div class="large-4 columns">
        <a href="editcategory.php" class="button add">Edit category</a>
    </div>
    <div class="large-12 columns">
        <?php if (Session::exists('category')) { ?>
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('category'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        <?php } ?>
    </div>
    <div class="large-12 columns">
        <dl class="tabs" data-tab>
            <dd class="active"><a href="#panel2-1">Feeds</a></dd>
            <dd><a href="#panel2-2">Bookmarks</a></dd>
        </dl>
        <div class="tabs-content">
            <div class="content active" id="panel2-1">
                <!-- Feeds go here -->
                <?php
                $feed = new Feed();
                $feeds = $feed->getAllByCategory(Input::get('cid'));
                ?>
                <ul class="listings">
                    <?php foreach ($feeds as $item) { ?>
                        <li class="list-item row"><a href="<?php echo escape($item->url); ?>" title="<?php echo escape($item->title); ?>" target="_blank"><?php echo escape($item->title); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="content" id="panel2-2">
                <!-- Bookmarks go here -->
                <?php
                $bookmark = new Bookmark();
                $bookmarks = $bookmark->getAllByCategory(Input::get('cid'));
                ?>
                <ul class="listings">
                    <?php foreach ($bookmarks as $book) { ?>
                        <li class="list-item row"><a href="<?php echo escape($book->url); ?>" title="<?php echo escape($book->title); ?>" target="_blank"><?php echo escape($book->title); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>