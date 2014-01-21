<?php 
require_once 'core/init.php'; 
$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
include_once 'includes/layout/header.php';

$bookmark = new Bookmark();
$bookmarks = $bookmark->getAll();
             
?>

    <div class="large-8 columns">
        <header class="large-8 columns page-head">
            <h1 class="page-title">Bookmarks</h1>
        </header>
        
        <div class="large-4 columns">
            <a href="addbookmark.php" class="button add">Add bookmark</a>
        </div>
        <div class="large-12 columns">
            <?php if(Session::exists('bookmark')){ ?>
            <div data-alert class="alert-box info radius">
                <?php echo Session::flash('bookmark'); ?>
                 <a href="#" class="close">&times;</a>
            </div>
            <?php } ?>
            <ul class="listings">            
            <?php foreach ($bookmarks as $bookmark){ ?>
              <li class="list-item row">
                  <div class="large-9 columns">
                     <a href="<?php echo escape($bookmark->url); ?>" title="<?php echo escape($bookmark->title); ?>" target="_blank"><?php echo escape($bookmark->title); ?></a> 
                     <?php 
                     if(!empty($bookmark->updated)){
                     ?>
                        <small>Updated: <?php echo escape($bookmark->updated); ?></small>
                     <?php
                     } else {
                     ?>
                        <small>Created: <?php echo escape($bookmark->created); ?></small>
                     <?php
                     }
                     ?>
                     
                  </div>
                  <div class="large-3 columns">
                      <ul class="actions">
                          <li class="action"><a href="updatebookmark.php?bid=<?php echo escape($bookmark->id); ?>" title="update" class="fi-pencil update"><span>Update</span></a></li>
                          <li class="action"><a href="deletebookmark.php?bid=<?php echo escape($bookmark->id); ?>" title="update" class="fi-trash delete"><span>Delete</span></a></li>
                      </ul>
                  </div>
            </li>  
                
            <?php } ?>
        </ul>
        </div>
    </div>

    <div class="large-4 columns">
    </div>

<?php include_once 'includes/layout/footer.php'; ?>