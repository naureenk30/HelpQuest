<?php
session_start();
//Including database connection file.
include 'include/db.php';

//Fetching ID from hidden input field in post request
$id = $_REQUEST['ad_id'];

//If no valid id send back to school page.
if($id == null) {
  $_SESSION['error_msg'] = 'Error: Please select degree you want to update.';
  header("Location: manage-degree.php");
}

//If vallid request, processed further.
if(isset($_POST['updateDegree'])) {
  $ad_name = $_POST['adName'];
  $ad_desc = $_POST['adDesc'];
  $comments = $_POST['adCmt'];
  $ad_id = $_POST['ad_id'];

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Trying to update data
  try {
    //Database query to update school.
    $sql = "UPDATE academic_degree SET ad_name = ?, ad_desc = ?, comments = ? WHERE ad_id = $ad_id";
    $q = $pdo->prepare($sql);
    $q->execute(array($ad_name, $ad_desc, $comments));

    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'Degree Edited and saved successfully.';
    echo header('Location: manage-degree.php');

  } catch(PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
  }
}

?>
