<?php

include 'functions/functions.php';
//authenticate user
$proceed = true;
session_start();
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
if (isset($_SESSION['login_attempts'])) {
    if ($_SESSION['login_attempts'] >= 10) {
        $proceed = false;
    }
}
if ($proceed) {
    $user = new User(-1);
    $user->email = $_POST['email'];
    $user->set_password($_POST['password']);
    error_log('authing...');
    $check = $user->authenticate_user();
    if ($check === true) {
        //user authenticated successfully
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user->get_user_id();
        if (isset($_POST['referral'])) {
            header('location: '.$_POST['referral']);
        } else {
            header('location:/index/loggedin');
        }
    } else {
        //authenticated failure
        if (isset($_SESSION['login_attempts'])) {
            ++$_SESSION['login_attempts'];
        } else {
            $_SESSION['login_attempts'] = 1;
        }
        header('location:/login-fail');
    }
} else {
    //maximum login attempts exceeded
    header('location:/login-max');
}
