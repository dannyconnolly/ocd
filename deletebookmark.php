<?php
require_once 'core/init.php'; 

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::get('bid')){
    $bookmark = new Bookmark();
    try{
         $bookmark->delete(Input::get('bid'));

         Session::flash('bookmark', 'Bookmark successfully deleted');
         Redirect::to('bookmarks.php');
     }
     catch(Exception $e){
         die($e->getMessage());
     }
} else {
    echo 'wrong';
}