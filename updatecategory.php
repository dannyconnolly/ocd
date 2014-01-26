<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
$category = new Category(Input::get('cid'));

include_once 'includes/layout/header.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'min' => 2,
                'max' => 45)
        ));

        if ($validate->passed()) {
            // register user
            try {
                $category->update(array(
                    'name' => Input::get('name'),
                    'updated' => date('Y-m-d H:i:s')
                        ), Input::get('cid'));

                Session::flash('category', 'Category successfully updated');
                Redirect::to('categories.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            // output errors
            foreach ($validate->errors() as $error) {
                echo $error . '<br />';
            }
        }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
        <legend>Update category</legend>
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo escape($category->data()->name); ?>" />
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
        <input type="submit" value="Update!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


