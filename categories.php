<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

$category = new Category();
$categories = $category->getAll();
?>

<div class="large-8 columns">
    <header class="large-8 columns page-head">
        <h1 class="page-title">Categories</h1>
    </header>

    <div class="large-4 columns">
        <a href="addcategory.php" class="button add">Add category</a>
    </div>
    <div class="large-12 columns">
        <?php if (Session::exists('category')) { ?>
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('category'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        <?php } ?>
        <ul class="listings">        
            <?php foreach ($categories as $category) { ?>
                <li class="list-item row">
                    <div class="large-9 columns">
                        <a href="category.php?cid=<?php echo escape($category->id); ?>" title="<?php echo escape($category->name); ?>"><?php echo escape($category->name); ?></a> 
                        <?php
                        if (!empty($category->updated)) {
                            ?>
                            <small>Updated: <?php echo formatDate(escape($category->updated)); ?></small>
                            <?php
                        } else {
                            ?>
                            <small>Created: <?php echo formatDate(escape($category->created)); ?></small>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="large-3 columns">
                        <ul class="actions">
                            <li class="action"><a href="updatecategory.php?cid=<?php echo escape($category->id); ?>" title="update" class="fi-pencil update"><span>Update</span></a></li>
                            <li class="action"><a href="deletecategory.php?cid=<?php echo escape($category->id); ?>" title="update" class="fi-trash delete" id="category-delete"><span>Delete</span></a></li>
                        </ul>
                    </div>
                </li>  
            <?php } ?>
        </ul>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>