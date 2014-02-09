<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
$bookmark = new Bookmark(Input::get('bid'));
$category = new Category();
$categories = $category->getAll(Session::getValue(Config::get('session/session_name')));

include_once 'includes/layout/header.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
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

        if ($validate->passed()) {
            // register user
            try {
                $bookmark->update(array(
                    'title' => Input::get('title'),
                    'url' => Input::get('url'),
                    'updated' => date('Y-m-d H:i:s')
                        ), Input::get('bid'));

                Session::flash('bookmark', 'Bookmark successfully updated');
                Redirect::to('bookmarks.php');
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
        <legend>Update bookmark</legend>
        <div class="field">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo escape($bookmark->data()->title); ?>" autocomplete="off"/>
        </div>
        <div class="field">
            <label for="url">Bookmark:</label>
            <input type="url" name="url" id="url" value="<?php echo escape($bookmark->data()->url); ?>" />
        </div>
        <div class="field">
            <fieldset>
                <legend>Category</legend>
                <ul class="category-list">
                    <?php
                    $cat_ids = $bookmark->getCatId(Input::get('bid'));
                    $i = 0;

                    foreach ($categories as $item) {
                        $cat_slug = str_replace(' ', '_', strtolower(escape($item->name)));
                        $id = $item->id;

                        if ($cat_ids[$i]->cat_id == $item->id) {
                            $selected = ' checked';
                        } else {
                            $selected = ' hot';
                        }
                        ?>
                        <li><input type="checkbox" name="category[<?php echo $cat_slug; ?>]" id="<?php echo $cat_slug; ?>" value="<?php echo escape($item->id); ?>"<?php echo $selected; ?>/> <label for="<?php echo $cat_slug; ?>"><?php echo escape($item->name); ?></label></li>
                    <?php } ?>
                </ul>
            </fieldset>
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
        <input type="submit" value="Update!" class="button" />
    </fieldset>
</form>
<?php include_once 'includes/layout/footer.php'; ?>


