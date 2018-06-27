<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['school_id']) {
      $_SESSION['error_msg'] = 'Error: Please select which school you want to delete.';
      header("Location: manage-school.php");
    }

    if ( !empty($_GET['school_id'])) {
        $school_id = $_REQUEST['school_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $school_id = $_POST['school_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM school  WHERE school_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($school_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'School deleted successfully.';

        //Redirecting back
        header("Location: manage-school.php");

    }

?>
