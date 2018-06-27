<?php
session_start();
include 'include/db.php';
//Fetching ID from hidden input field in post request
$id = $_REQUEST['user_id'];
//If no valid id send back to school page.
if($id == null) {
  $_SESSION['error_msg'] = 'Error: Please select which Superuser you want to update.';
  header("Location: manage-user.php");
}
//If vallid request, processed further.
if(isset($_POST['updateUser'])) {
  $name = $_POST['userName'];
  $email = $_POST['userEmail'];
  $password = $_POST['userPassword'];
  $school_id = $_POST['school_id'];
  //check if user changed password or not.
  $conn = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $data = $conn->prepare("SELECT password FROM user_info WHERE user_id = $id");
  $data->execute(array($id));
  $pass = $data->fetch();
  if($pass['password'] !== $password) {
    //if user change password then hash it and store.
    $new_pass = md5($password);
  } else {
    $new_pass = $pass['password'];
 }
  //Trying to update data
  try {
    //Database query to update school.
    $sql = "UPDATE user_info SET name = ?, email = ?, school_id = ?, password = ? WHERE user_id = $id";
    $q = $pdo->prepare($sql);
    $q->execute(array($name, $email, $school_id, $new_pass));
    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'Superuser Edited and saved successfully.';
    echo header('Location: manage-user.php');
  } catch(PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
  }
}
?>
