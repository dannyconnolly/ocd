<div class="dw-box">
    <header class="dw-header">
        <h3><span class="fi-torso"></span>Your Profile</h3>
    </header>
    <div class="dw-profile row">
        <div class="large-4 columns dw-gravatar">
            <span class="th">
                <img src="<?php echo $user->get_gravatar(escape($user->data()->email)); ?>" alt="<?php echo escape($user->data()->name); ?>" />
            </span>
        </div>
        <div class="large-8 columns dw-profile-text">
            <h4><?php echo escape($user->data()->name); ?></h4>
            <p><?php echo escape($user->data()->email); ?></p>
            <small>Member Since <?php echo formatDate(escape($user->data()->joined), 'jS F Y'); ?></small>
            <a href="update.php" title="edit profile">Edit profile</a>
        </div>

    </div>
</div>