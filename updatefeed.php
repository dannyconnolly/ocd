<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
$feed = new Feed(Input::get('fid'));
$category = new Category();
$categories = $category->getAll();
include_once 'includes/layout/header.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'min' => 2,),
            'url' => array(
                'required' => true,
                'min' => 6
            )
        ));

        if ($validate->passed()) {
            // register user
            try {
                $feed->update(array(
                    'title' => Input::get('title'),
                    'url' => Input::get('url'),
                    'updated' => date('Y-m-d H:i:s')
                        ), Input::get('fid'));

                Session::flash('feed', 'Feed successfully updated');
                Redirect::to('feeds.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . '<br />';
            }
        }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
        <legend>Update feed</legend>
        <div class="field">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo escape($feed->data()->title); ?>" />
        </div>
        <div class="field">
            <label for="url">Feed:</label>
            <input type="url" name="url" id="url" value="<?php echo escape($feed->data()->url); ?>" />
        </div>
        <div class="field">
            <fieldset>
                <legend>Category</legend>
                <ul class="category-list">
                    <?php
                    $cat_ids = $feed->getCatId(Input::get('fid'));
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


