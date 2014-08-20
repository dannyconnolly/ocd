<?php
require_once 'core/init.php';
include_once 'includes/layout/header.php';

if (Session::exists('home')) {
    echo Session::flash('home');
}
?>
<div class="large-8 columns large-centered home-box">
    <?php if (Session::exists('dashboard')) { ?>
        <div class="large-12 columns">
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('dashboard'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        </div>
    <?php } ?>
    <h1>Online Content Dashboard</h1>
</div>
<?php include_once 'includes/layout/footer.php'; ?>