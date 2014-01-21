<?php
require_once 'core/init.php'; 
$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'min' => 2,
                'max' => 64),
            'url' => array(
                'required' => true,
                'min' => 6 //,
               // 'unique' => true,
                // 'valid_url' => true
            )
        ));

      if($validate->passed()){
            // register user          
         
          $feed = new Feed();
         try{
              $feed->create(array(
                  'title' => Input::get('title'),
                  'url' => Input::get('url'),
                  'created' => Input::get('created')
              ));
              
              Session::flash('feed', 'Feed successfully added');
              Redirect::to('feeds.php');
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
    <legend>Add feed</legend>
    <div class="field">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo escape(Input::get('title')); ?>" />
    </div>
    <div class="field">
        <label for="url">Feed:</label>
        <input type="url" name="url" id="url" value="<?php echo escape(Input::get('url')); ?>" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s') ?>"/>
    <input type="submit" value="Add!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


