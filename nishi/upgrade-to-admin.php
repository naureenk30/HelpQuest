<?php
    session_start();
    include 'include/db.php';
    //Fetching ID from hidden input field in post request
    $id = $_REQUEST['user_id'];
    $is_admin = true;
    $is_supperUser = false;
    //If no valid id send back to school page.
    if($id == null) {
      $_SESSION['error_msg'] = 'Error: Select Superuser first to update.';
      header("Location: manage-user.php");
    }
    $pdo = Database::connect();
    $sql = "UPDATE user_info SET is_admin = ?, is_superUser = ? WHERE user_id = $id";
    $q = $pdo->prepare($sql);
    $q->execute(array($is_admin, $is_supperUser));
    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'User saved as admin.';
    echo header('Location: manage-user.php');
?>
