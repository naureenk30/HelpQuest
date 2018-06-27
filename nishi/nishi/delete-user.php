<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['user_id']) {
      $_SESSION['error_msg'] = 'Error: Please select which user you want to delete.';
      header("Location: manage-user.php");
    }

    if ( !empty($_GET['user_id'])) {
        $user_id = $_REQUEST['user_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $user_id = $_POST['user_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM user_info WHERE user_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($user_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'User deleted successfully.';

        //Redirecting back
        header("Location: manage-user.php");

    }

?>
