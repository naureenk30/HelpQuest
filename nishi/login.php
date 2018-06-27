<?php
  include 'include/header.php';
  require 'include/db.php';

  //starting session to store error, success and loggedin user.
  session_start();

  //check if user is already logged in or not.
  if(isset($_SESSION['logged_in'])) {
    $_SESSION['success_msg'] = 'You are already logged in';
    echo header('Location:index.php');
  }

  //user clicked on login button
  if(isset($_POST['loginUser'])) {

    //trim will remove white space.
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //We saved password with md5 hash while signup.
    $password = md5($password);

    //check if username and password field are not empty.
    if(empty($email) && empty($password)) {
      $_SESSION['error_msg'] = 'Please fill email and password before submitting form.';
    }

    try {
          $pdo = Database::connect();
          $sql = "SELECT * FROM user_info WHERE email = ? AND password = ?";

          $stmt = $pdo->prepare($sql);
          $stmt->execute(array($email, $password));

          //If found any user.
          $count = $stmt->rowCount();

          //If found any user save tha as $user variable
          $user = $stmt->fetch(PDO::FETCH_OBJ);

            if($count) {
              //If found user save session and redirect to home.
              $_SESSION['logged_in'] = $user->user_id;

              //if logged in user is admin or not.
              if($user->is_admin) {
                $_SESSION['admin_logged_in'] = $user->user_id;
                $_SESSION['admin_name'] = $user->name;
              }

              //if superuser is logged in
              if($user->is_superUser) {
                $_SESSION['supper_user_logged_in'] = $user->user_id;
              }

              //if logged in user is student.
              if($user->is_student) {
                $_SESSION['student_log'] = $user->user_id;
              }

              $_SESSION['success_msg'] = 'Welome back, you are now logged in.';
              echo header('Location:index.php');

            } else {
              //If invalid detail reurn back to login page with error message
              $_SESSION['error_msg'] = 'Please check your username or password. No user found';
            }

        } catch(PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
  }

?>

<div class="container">

  <!-- including alert file to show messages -->
  <?php include 'include/alert.php';?>

  <div class="row" id="login-page-container">
    <div class="col login-left-col">
      <h3>HelpQuest</h3>
      <p>Enter your email and password on right side, after Login
      you will be able to </p>
      <ul>
        <li>Admin will be able to upload question paper on semester and year basis.</li>
        <li>Superuser will be able to upload question paper on semester and year basis.</li>
      </ul>

  <!--<a href="add-new-student.php" role="button" class="btn btn-md btn-info"><i class="fa fa-user-plus"></i> Student registration</a>-->
  <a href="student-view-papers.php" role="button" class="btn btn-md btn-secondary"><i class="fa fa-eye"></i> View papers</a>

    </div>
    <div class="col login-col">

      <h3>Login below:</h3>

      <form class="login-form" action="login.php" method="post">

            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your valid email">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your passwords">
            </div>

            <button type="submit" name="loginUser" class="btn btn-primary"> <i class="fas fa-sign-in-alt"> </i>  Log in</button>
            <button type="reset" class="btn btn-danger"><i class="fas fa-history"></i> Reset form</button>

      </form> <!-- Ending login form -->

    </div>
  </div>
</div>
<?php include 'include/footer.php';?>
