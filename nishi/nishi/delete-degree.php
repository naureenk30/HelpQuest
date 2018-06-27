<?php
  include 'include/db.php';
  session_start();

    //If no id given
    if(!$_REQUEST['ad_id']) {
      $_SESSION['error_msg'] = 'Error: Please select which degree you want to delete.';
      header("Location: manage-degree.php");
    }

    if ( !empty($_GET['ad_id'])) {
        $ad_id = $_REQUEST['ad_id'];
    }

    //If everything is fine go ahead and delete.
    if ( !empty($_POST)) {
        // keep track post values
        $ad_id = $_POST['ad_id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM academic_degree WHERE ad_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($ad_id));
        Database::disconnect();

        //Notifying user if school deleted.
        $_SESSION['success_msg'] = 'degree deleted successfully.';

        //Redirecting back
        header("Location: manage-degree.php");

    }

?>
