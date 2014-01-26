<?php
require_once 'core/init.php';

include_once 'includes/layout/header.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
                'valid_email' => true
            )
        ));

        if ($validate->passed()) {
            try {
                $user->update(array(
                    'username' => Input::get('username'),
                    'name' => Input::get('name'),
                    'email' => Input::get('email')
                ));

                Session::flash('profile', 'Your details have been updated');
                Redirect::to('profile.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors as $error) {
                echo $error . '<br />';
            }
        }
    }
}
?>
<form method="POST" action="" class="large-8 column large-centered">
    <fieldset>
        <legend>Update profile</legend>
        <div class="field">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo escape($user->data()->username); ?>" id="username" />
        </div>
        <div class="field">
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo escape($user->data()->email); ?>" id="email" />
        </div>
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo escape($user->data()->name); ?>" id="name" />
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
        <input type="submit" value="Update!" class="button" />
    </fieldset>
</form>

<?php include_once 'includes/layout/footer.php'; ?>