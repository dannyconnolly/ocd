<?php
require_once 'core/init.php'; 

include_once 'includes/layout/header.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'min' => 2,
                'max' => 45)
        ));

      if($validate->passed()){
            // register user          
         
          $category = new Category();
         try{
              $category->create(array(
                  'name' => Input::get('name'),
                  'created' => Input::get('created')
              ));
              
              Session::flash('category', 'Category successfully added');
              Redirect::to('categories.php');
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
    <legend>Add category</legend>
    <div class="field">
        <label for="name">Name:</label>
        <input type="text" name="name" id="title" value="<?php echo escape(Input::get('name')); ?>" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s') ?>"/>
    <input type="submit" value="Add!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


