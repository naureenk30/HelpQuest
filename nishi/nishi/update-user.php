<?php
session_start();
//Codes to update school.
//Including database connection file.
include 'include/db.php';

//Fetching ID from hidden input field in post request
$id = $_REQUEST['user_id'];

//If no valid id send back to school page.
if($id == null) {
  $_SESSION['error_msg'] = 'Error: Please select which user you want to update.';
  header("Location: manage-user.php");
}

//If vallid request, processed further.
if(isset($_POST['updateUser'])) {
  $name = $_POST['userName'];
  $email = $_POST['userEmail'];
  $password = $_POST['userPassword'];

  //check if user changed password or not.
  $conn = Database::connect();
  $data = $conn->prepare("SELECT password FROM user_info WHERE user_id = $id");
  $data->execute(array($id));
  $pass = $data->fetch();

    if($pass['password'] !== $password) {
      //if user change password then hash it and store.
      $new_pass = md5($password);
    } else {
      $new_pass = $pass['password'];
    }

  $school_id = $_POST['school_id'];
  $admin = $_POST['admin'];

  //Check admin data.
  if($admin == null OR $admin == '0') {
    $admin = false;
  } else {
    $admin = true;

    //If admin is true then we will disable super user as that was default so have to change now.
    $superUser = false;
  }

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Trying to update data
  try {
    //Database query to update school.
    $sql = "UPDATE user_info SET name = ?, email = ?, school_id = ?, password = ?, is_admin = ?, is_superUser = ? WHERE user_id = $id";
    $q = $pdo->prepare($sql);
    $q->execute(array($name, $email, $school_id, $new_pass, $admin, $superUser));

    //Redirecting back to school page if edited..
    $_SESSION['success_msg'] = 'User Edited and saved successfully.';
    echo header('Location: manage-user.php');

  } catch(PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
  }
}

?>
