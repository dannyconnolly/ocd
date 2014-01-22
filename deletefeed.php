<?php
require_once 'core/init.php'; 

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::get('fid')){
    $feed = new Feed();
    try{
         $feed->delete(Input::get('fid'));

         Session::flash('feed', 'Feed successfully deleted');
         Redirect::to('feeds.php');
     }
     catch(Exception $e){
         die($e->getMessage());
     }
} else {
    echo 'wrong';
}