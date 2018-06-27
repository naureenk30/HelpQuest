<?php
  session_start();
  include('include/db.php');
  include('include/header.php');

//code to register new sudent.
if(isset($_POST['addStudent'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  //we are registering student so set false to admin and superuser.
  $is_admin = false;
  $is_superUser = false;
  $is_student = true;

  //set a variable to check form validation.
  $valid = true;
  $errors = array();

  //Check if email already exists in database.
  $pdo = Database::connect();
  $stmt = $pdo->prepare("SELECT * FROM user_info WHERE email = ?");
  $stmt->execute(array($email));
  $data = $stmt->rowCount();

  if($data) {
    $errors[] = 'This email already exist, please choose another one.';
    $valid = false;
 }

  //check if password lenght is not strong.
  if(strlen($password) < 6) {
    $errors[] = 'Please choose a strong password, minimum of 6 characters long.';
    $valid = false;
  } else {
    $password = md5($_POST['password']);
    $valid = true;
  }

  //if name is empty.
  if(empty($name)) {
    $errors[] = 'Please enter your name';
    $valid = false;
  }

  //check if email is not valid.
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   $errors[] = 'Please enter valid email address.';
   $valid = false;
 }

 //if everything fine.

 if($valid) {
   $pdo = Database::connect();
   $sql = "INSERT INTO user_info (name, email, password, is_admin, is_superUser, is_student) VALUES (?, ?, ?, ?, ?, ?)";
   $stmt = $pdo->prepare($sql);
   $student = $stmt->execute(array($name, $email, $password, $is_admin, $is_superUser, $is_student));

   if($student) {
     $link = "<a class='alert_link' href='login.php'> click here <a>";
     $_SESSION['success_msg'] = "Student registered successfully " .  $link . " to login";
   }
 }

 if(count($errors) > 0) {
   $_SESSION['errors'] = $errors;
  }
}

?>

<div class="container">
    <?php include 'include/alert.php';?>
    <h1>Student registration</h1>
    <p>
      Please enter your name, email and password to sign up as a student. <br>
      Already have account? <a href="login.php" class="login_st_link">click here to login</a>
    </p>

    <div class="row">
      <div class="col form-col">

        <form class="col-8" method="post">

          <div class="form-group">
            <label for="name">Enter Name:</label>
            <input type="text" id="name" class="form-control" placeholder="Enter your name" name="name">
          </div>

          <div class="form-group">
            <label for="email">Enter Email:</label>
            <input type="email" id="email" class="form-control" placeholder="Enter your valid email address" name="email">
          </div>

          <div class="form-group">
            <label for="password">Enter password (Min. 6 characters long):</label>
            <input type="password" id="password" class="form-control" placeholder="Enter strong password" name="password">
          </div>

          <div class="form-group">
            <button type="submit" name="addStudent" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Signup </button>
            <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
          </div>
      </form>
      </div>
    </div>

  </div> <!-- closing of container div -->

<?php include "include/footer.php";?>
