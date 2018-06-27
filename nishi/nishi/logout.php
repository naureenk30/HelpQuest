<?php
session_start();
unset($_SESSION['logged_in']);
session_destroy();
$_SESSION['success_msg'] = 'You are logged out from app.';
echo header('Location:login.php');
?>
