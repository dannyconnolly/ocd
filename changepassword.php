<?php
require_once 'core/init.php'; 
include_once 'includes/layout/header.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));
        
        if($validate->passed()){
            if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
                echo 'password is wrong';
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));
                
                Session::flash('home', 'Your password has been changed');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validate->errors() as $error){
                echo $error.'<br />';
            }
        }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
    <legend>Change password</legend>
    
    <div class="field">
        <label for="password_current">Current Password:</label>
        <input type="password" name="password_current" id="password_current" />
    </div>
     <div class="field">
        <label for="password_new">New Password:</label>
        <input type="password" name="password_new" id="password_new" />
    </div>
    <div class="field">
        <label for="password_new_again">New Password Again:</label>
        <input type="password" name="password_new_again" id="password_new_again" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="submit" value="Change!" class="button" />
    </fieldset>
</form>

<?php include_once 'includes/layout/footer.php'; ?>