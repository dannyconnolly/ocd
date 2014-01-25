<?php
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

$feed = new Feed();
$feeds = $feed->getAll();
?>

<div class="large-8 columns">
    <header class="large-8 columns page-head">
        <h1 class="page-title">Feeds</h1>
    </header>

    <div class="large-4 columns">
        <a href="addfeed.php" class="button add">Add feed</a>
    </div>
    <div class="large-12 columns">
        <?php if (Session::exists('feed')) { ?>
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('feed'); ?>
                <a href="#" class="close">&times;</a>
            </div>
        <?php } ?>
        <dl class="accordion" data-accordion>
            <?php
            $i = 1;
            foreach ($feeds as $item) {
                ?>
                <dd>
                    <a href="#panel<?php echo $i; ?>"><?php echo escape($item->title); ?>
                        <?php
                        if (!empty($item->updated)) {
                            ?>
                            <small>Updated: <?php echo formatDate(escape($item->updated)); ?></small>
                            <?php
                        } else {
                            ?>
                            <small>Created: <?php echo formatDate(escape($item->created)); ?></small>
                            <?php
                        }
                        ?>
                    </a>

                    <div id="panel<?php echo $i; ?>" class="content active">
                        <div class="large-3 columns">
                            <ul class="actions">
                                <li class="action"><a href="updatefeed.php?fid=<?php echo escape($item->id); ?>" title="update" class="fi-pencil update"><span>Update</span></a></li>
                                <li class="action"><a href="deletefeed.php?fid=<?php echo escape($item->id); ?>" title="update" class="fi-trash delete"><span>Delete</span></a></li>
                            </ul>

                        </div>
                    </div>
                </dd>  

                <?php
                $i++;
            }
            ?>
        </dl>

        </ul>
    </div>
</div>

<div class="large-4 columns">
</div>

<?php include_once 'includes/layout/footer.php'; ?>