<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

$category = new Category();
$categories = $category->getAll(Session::getValue(Config::get('session/session_name')));
?>

<div class="large-8 columns">
    <ul class="breadcrumbs">
        <li><a href="<?php echo $home = $user->isLoggedIn() ? 'dashboard' : 'index'; ?>.php">Home</a></li>
        <li class="current"><a href="#">Categories</a></li>
    </ul>
    <header class="page-head">
        <h1 class="page-title">Categories</h1>
    </header>

    <div class="row">
        <div class="container large-12 columns">
            <?php if (Session::exists('category')) { ?>
                <div data-alert class="alert-box info radius">
                    <?php echo Session::flash('category'); ?>
                    <a href="#" class="close">&times;</a>
                </div>
            <?php } ?>
            <ul class="small-block-grid-4">        
                <?php foreach ($categories as $item) { ?>
                    <li>
                        <div class="category-list-box">
                            <a href="category.php?cid=<?php echo escape($item->id); ?>" title="<?php echo escape($item->name); ?>"><?php echo escape($item->name); ?></a> 
                            <p><?php echo $category->feedCount(escape($item->id)); ?> Feeds</p>
                            <p><?php echo $category->bookmarkCount(escape($item->id)); ?> Bookmarks</p>
                        </div>
                    </li>  
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>