<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['paper_id']) {
      $_SESSION['error_msg'] = 'Error: You have to select subjpaper to delete.';
      header("Location: manage-question-paper.php");
    }

    if ( !empty($_GET['paper_id'])) {
        $paper_id = $_REQUEST['paper_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $paper_id = $_POST['paper_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM questionbank  WHERE q_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($paper_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'Question paper deleted successfully.';

        //Redirecting back
        header("Location: manage-question-paper.php");

    }

?>
