<?php
require_once 'core/init.php'; 
include_once 'includes/layout/header.php';

if(!$username = Input::get('user')){
    Redirect::to('index.php');
} else {
    $user = new User($username);
    if(!$user->exists()){
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
}

?>
<div row>
    <div class="large-8 columns">
        <div class="panel">
            <h3><?php echo escape($data->username); ?></h3>
            <p>Full name: <?php echo escape($data->name); ?> </p>  
        </div>
    </div>
    <div class="large-4 columns"></div>
</div>

<?php include_once 'includes/layout/footer.php'; ?>