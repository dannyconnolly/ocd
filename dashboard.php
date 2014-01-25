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

</div>
<?php include_once 'includes/layout/footer.php'; ?>