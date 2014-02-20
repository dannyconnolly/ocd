<?php
require_once 'core/init.php';
include_once 'includes/layout/header.php';

if (Session::exists('home')) {
    echo Session::flash('home');
}
?>
<div class="large-8 columns large-centered home-box">
    <h1>Online Content Dashboard</h1>
</div>
<?php include_once 'includes/layout/footer.php'; ?>