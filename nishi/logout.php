<?php
session_start();
unset($_SESSION['logged_in']);
unset($_SESSION['admin_logged_in']);
unset($_SESSION['supper_user_logged_in']);

$_SESSION['success_msg'] = 'You are logged out from app.';
session_destroy();
echo header('Location:login.php');
?>
