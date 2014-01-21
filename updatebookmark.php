<?php
require_once 'core/init.php'; 

$bookmark = new Bookmark(Input::get('bid'));

include_once 'includes/layout/header.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'min' => 2,),
            'url' => array(
                'required' => true,
                'min' => 6 //,
               // 'unique' => true,
                // 'valid_url' => true
            )
        ));

      if($validate->passed()){
            // register user
         try{
              $bookmark->update(array(
                  'title' => Input::get('title'),
                  'url' => Input::get('url'),
                  'updated' => Input::get('updated')
              ), Input::get('bid'));
              
              Session::flash('bookmark', 'Bookmark successfully updated');
              Redirect::to('bookmarks.php');
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
    <legend>Update bookmark</legend>
    <div class="field">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo escape($bookmark->data()->title); ?>" autocomplete="off"/>
    </div>
    <div class="field">
        <label for="url">Bookmark:</label>
        <input type="url" name="url" id="url" value="<?php echo escape($bookmark->data()->url); ?>" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="hidden" name="updated" value="<?php echo date('Y-m-d H:i:s') ?>"/>
    <input type="submit" value="Update!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


