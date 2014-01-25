<?php
require_once 'core/init.php'; 

include_once 'includes/layout/header.php';
if(Input::exists()){
    if(Token::check(Input::get('token'))){
      $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
        ));

      if($validate->passed()){
            // register user          
      
          $user = new User();
          
          $salt = Hash::salt(32);
          
         try{
              //echo 'trying...';
              $user->create(array(
                  'username' => Input::get('username'),
                  'password' => Hash::make(Input::get('password'), $salt),
                  'salt' => $salt,
                  'name' => Input::get('name'),
                  'joined' => date('Y-m-d H:i:s'),
                  'group' => 1
              ));
              
              Session::flash('login', 'User successfully registered');
              Redirect::to('login.php');
          }
          catch(Exception $e){
              die($e->getMessage());
          }
     } else {
            // output errors
         foreach($validate->errors() as $error){
             echo $error.'<br />';
         }
       }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
    <legend>Register</legend>
    <div class="field">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"/>
    </div>
    <div class="field">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" />
    </div>
     <div class="field">
        <label for="password_again">Confirm Password:</label>
        <input type="password" name="password_again" id="password_again" />
    </div>
    <div class="field">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="submit" value="Register!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>
