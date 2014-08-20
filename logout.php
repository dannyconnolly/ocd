<?php

require_once 'core/init.php';

$user = new User();

$user->logout();

Session::flash('dashboard', 'Successfully logged out');
Redirect::to('index.php');
?>