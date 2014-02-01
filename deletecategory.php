<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::get('cid')) {
    $category = new Category();
    try {
        $category->delete(Input::get('cid'));

        Session::flash('category', 'Category successfully deleted');
        Redirect::to('categories.php');
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    echo 'wrong';
}