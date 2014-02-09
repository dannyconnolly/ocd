<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';
$category = new Category();
$categories = $category->getAll(Session::getValue(Config::get('session/session_name')));

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'min' => 2,
                'max' => 64),
            'url' => array(
                'required' => true,
                'min' => 6,
                'unique' => 'feeds')
        ));

        if ($validate->passed()) {
            // register user          

            $feed = new Feed();
            try {
                $last_feed_id = $feed->create(array(
                    'title' => Input::get('title'),
                    'url' => Input::get('url'),
                    'created' => Input::get('created'),
                    'user_id' => Session::getValue(Config::get('session/session_name'))
                ));

                if (Input::get('category_name')) {
                    $last_category_id = $category->create(array(
                        'name' => Input::get('category_name'),
                        'created' => Input::get('created')
                    ));

                    $category->setRelationship(array(
                        'cat_id' => $last_category_id,
                        'feed_id' => $last_feed_id
                    ));
                } elseif (Input::get('category')) {
                    foreach (Input::get('category') as $value) {
                        $category->setRelationship(array(
                            'cat_id' => $value,
                            'feed_id' => $last_feed_id
                        ));
                    }
                }

                Session::flash('feed', 'Feed successfully added');
                Redirect::to('feeds.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            ?>
            <div class="large-8 column large-centered">
                <?php
                foreach ($validate->errors() as $error) {
                    ?>
                    <div data-alert class="alert-box warning radius">
                        <?php echo $error; ?>
                        <a href="#" class="close">&times;</a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}
?>
<div class="large-12">
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
            <div class="field">
                <fieldset>
                    <legend>Category</legend>
                    <?php
                    if (empty($categories)) {
                        ?>
                        <div class="field">
                            <label for="category_name">Add category:</label>
                            <input type="text" name="category_name" id="category_name" value="<?php echo escape(Input::get('category_name')); ?>" />
                        </div>
                        <?php
                    } else {
                        ?>
                        <a href="addcategory.php" title="Add category">Add category</a>
                        <ul class="category-list">
                            <?php
                            foreach ($categories as $item) {
                                $cat_slug = str_replace(' ', '_', strtolower(escape($item->name)));
                                ?>
                                <li><input type="checkbox" name="category[<?php echo $cat_slug; ?>]" id="<?php echo $cat_slug; ?>" value="<?php echo escape($item->id); ?>"/> <label for="<?php echo $cat_slug; ?>"><?php echo escape($item->name); ?></label></li>
                            <?php }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </fieldset>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
            <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s') ?>"/>
            <input type="submit" value="Add!" class="button" />
        </fieldset>
    </form>
</div>
<?php include_once 'includes/layout/footer.php'; ?>


