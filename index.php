<?php 
require_once 'core/init.php'; 
include_once 'includes/layout/header.php';

if(Session::exists('home')){
    echo Session::flash('home');
}
?>
<div class="large-8 columns">
    <h1>Vault</h1>
</div>
<div class="large-4 columns">
    </div>
<?php
/*if($user->isLoggedIn()){
    if($user->hasPermission('admin')){
    }
} else {
}
*/

include_once 'includes/layout/footer.php';
?>