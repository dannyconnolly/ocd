<?php
require_once 'core/init.php';
include_once 'includes/layout/header.php';
    
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
     
        if($validate->passed()){
            $user = new User();
            
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);
            
            if($login){
                Redirect::to('index.php');
            }
            else {
                echo 'failure';
            }
        }else{
            foreach($validate->errors() as $error){
                echo $error.'<br />';
            }
        }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
    <legend>Login</legend>
    <div class="field">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"/>
    </div>
    <div class="field">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" />
    </div>
    <div class="field">
        <input type="checkbox" name="remember" id="remember" />
        <label for="remember">Remember me?</label>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="submit" value="Login!" class="button" />
    </fieldset>
</form>

<?php include_once 'includes/layout/header.php'; ?>