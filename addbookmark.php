<?php
require_once 'core/init.php'; 
$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

include_once 'includes/layout/header.php';
$category = new Category();
$categories = $category->getAll();

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
          $bookmark = new Bookmark();
         try{
              $rid = $bookmark->create(array(
                  'title' => Input::get('title'),
                  'url' => Input::get('url'),
                  'created' => Input::get('created')
              ));
              
              foreach (Input::get('category') as $value) {
                  $category->setRelationship(array(
                      'cat_id' => $value,
                      'bookmark_id' => $rid
                  ));
              }              
              
              Session::flash('bookmark', 'Bookmark successfully added');
              Redirect::to('bookamrks.php');
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
    <legend>Add bookmark</legend>
    <div class="field">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo escape(Input::get('title')); ?>" />
    </div>
    <div class="field">
        <label for="url">Bookmark:</label>
        <input type="url" name="url" id="url" value="<?php echo escape(Input::get('url')); ?>" />
    </div>
    <div class="field">
        <fieldset>
            <legend>Category</legend>
            <ul class="category-list">
                <?php foreach ($categories as $item) { 
                    $cat_slug = str_replace(' ', '_', strtolower(escape($item->name)));
                    ?>
                <li><input type="checkbox" name="category[<?php echo $cat_slug; ?>]" id="<?php echo $cat_slug; ?>" value="<?php echo escape($item->id); ?>"/> <label for="<?php echo $cat_slug; ?>"><?php echo escape($item->name); ?></label></li>
                <?php } ?>
            </ul>
         </fieldset>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s') ?>"/>
    <input type="submit" value="Add!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


