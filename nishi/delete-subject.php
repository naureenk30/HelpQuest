<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['sub_id']) {
      $_SESSION['error_msg'] = 'Error: You have to select subject to delete.';
      header("Location: manage-subject.php");
    }

    if ( !empty($_GET['sub_id'])) {
        $sub_id = $_REQUEST['sub_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $sub_id = $_POST['sub_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM subject  WHERE sub_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($sub_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'Subject deleted successfully.';

        //Redirecting back
        header("Location: manage-subject.php");

    }

?>
