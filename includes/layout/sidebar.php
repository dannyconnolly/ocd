<?php
$category = new Category();
$categories = $category->getAll(Session::getValue(Config::get('session/session_name')));
?> 


<div class="large-2 columns sidebar" data-equalizer-watch>
    <a href="addcategory.php" class="add" id="add-category"><span class="fi-plus"></span>Add Category</a>
    <a href="addbookmark.php" class="add" id="add-bookmark"><span class="fi-plus"></span>Add Bookmark</a>
    <a href="addfeed.php" class="add" id="add-feed"><span class="fi-plus"></span>Add Feed</a>
	<div class="large-12 large-centered columns">
		<ul class="side-nav">
			<li	class="divider"></li>
			<li><strong>Categories</strong></li>
			<li	class="divider"></li>
			<?php foreach ($categories as $category) { ?>
				<li class="list-item<?php echo $class = Input::get('cid') == escape($category->id) ? ' active' : ''; ?>">
					<a href="category.php?cid=<?php echo escape($category->id); ?>" title="<?php echo escape($category->name); ?>"><?php echo escape($category->name); ?></a>
				</li>  
			<?php } ?>
		</ul>
	</div>
</div>


