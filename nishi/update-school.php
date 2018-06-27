<?php
session_start();
//Codes to update school.
//Including database connection file.
include 'include/db.php';

//Fetching ID from hidden input field in post request
$id = $_REQUEST['school_id'];

//If no valid id send back to school page.
if($id == null) {
  $_SESSION['error_msg'] = 'Error: Please select which school you want to update.';
  header("Location: manage-school.php");
}

//If vallid request, processed further.
if(isset($_POST['updateSchool'])) {
  $name = $_POST['schoolName'];
  $desc = $_POST['schoolDesc'];
  $comments = $_POST['schoolCmt'];
  $school_id = $_POST['school_id'];

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Trying to update data
  try {
    //Database query to update school.
    $sql = "UPDATE school SET school_name = ?, school_desc = ?, comments = ? WHERE school_id = $school_id";
    $q = $pdo->prepare($sql);
    $q->execute(array($name, $desc, $comments));

    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'School Edited and saved successfully.';
    echo header('Location: manage-school.php');

  } catch(PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
  }
}

?>
