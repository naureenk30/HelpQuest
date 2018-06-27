<?php
session_start();
//Codes to update school.
//Including database connection file.
include 'include/db.php';

//Fetching ID from hidden input field in post request
$sub_id = $_REQUEST['sub_id'];

//If no valid id send back to school page.
if($sub_id == null) {
  $_SESSION['error_msg'] = 'Error: Please select which subject you want to update.';
  header("Location: manage-subject.php");
}

//If vallid request, processed further.
if(isset($_POST['updateSub'])) {
  $sub_name = $_POST['subName'];
  $sub_code = $_POST['subCode'];
  $sub_desc = $_POST['subDesc'];
  $comments = $_POST['subCmt'];
  $sub_id = $_POST['sub_id'];

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Trying to update data
  try {
    //Database query to update school.
    $sql = "UPDATE subject SET sub_code = ?, sub_name = ?, sub_desc = ?, comments = ? WHERE sub_id = $sub_id";
    $q = $pdo->prepare($sql);
    $q->execute(array($sub_code, $sub_name, $sub_desc, $comments));

    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'Subject Edited and saved successfully.';
    echo header('Location: manage-subject.php');

  } catch(PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
  }
}

?>
