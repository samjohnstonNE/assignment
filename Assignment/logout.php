<?php
require_once('functions.php');
getSession();

unset($_SESSION['username']);
unset($_SESSION['password']);
//$_SESSION['logged-in'] = false;
$_SESSION = array();
session_destroy();  //sessions is deleted

header('location: ' .$_SERVER['HTTP_REFERER']);



/**
 * Created by PhpStorm.
 * User: SammyJ
 * Date: 25/11/2019
 * Time: 07:54 PM
 */