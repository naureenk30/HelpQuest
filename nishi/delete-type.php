<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['qt_id']) {
      $_SESSION['error_msg'] = 'Error: You can not delete question type without selecting it.';
      header("Location: manage-question-type.php");
    }

    if ( !empty($_GET['qt_id'])) {
        $qt_id = $_REQUEST['qt_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $qt_id = $_POST['qt_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM questiontype WHERE qt_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($qt_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'Question type deleted successfully.';

        //Redirecting back
        header("Location: manage-question-type.php");

    }

?>
