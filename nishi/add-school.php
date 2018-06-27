<?php
//Including header, navbar and database connection files.
session_start();
include "include/header.php";
include "include/navbar.php";
include "include/db.php";

//if logged in user is super user then redirect to home page.
if(isset($_SESSION['supper_user_logged_in'])) {
  $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
  echo header ("Location: index.php");
}

  //Codes to add new school
  //Initially set all field values to null
  $school_name = null;
  $school_desc = null;
  $comments = null;
  $success = null;

  //If fields have value and form submitted
  if(isset($_POST['addSchool'])) {
    //Form field values.
    $school_name = $_POST['schoolName'];
    $school_desc = $_POST['schoolDesc'];
    $comments = $_POST['schoolCmt'];

    //Adding currenct time as injected_at
    $time = new DateTime();
    $time = $time->format('U = Y-m-d H:i:s');

    $pdo = Database::connect();

    //How server respond back
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO school (school_name,school_desc,comments, injected_date) values(?, ?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($school_name,$school_desc,$comments, $time));
      Database::disconnect();

      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'School added successfully :)';

    } catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

  };

?>

<div class="container">

    <?php include 'include/alert.php';?>
    <h1>Add school</h1>
    <p>
      Fill the school name, school description and click on save to add new school.
    </p>

  <div class="row">
    <div class="col form-col" id="addSchool">

      <form class="col-8" action="add-school.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter school name" name="schoolName" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter school description" name="schoolDesc" required>
        </div>
        <div class="form-group">
          <textarea class="form-control" placeholder="Enter school comments..." name="schoolCmt" required></textarea>
        </div>
        <div class="form-group">
          <button type="submit" name="addSchool" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Add new school</button>
          <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
        </div>
    </form>
    </div>
  </div>

</div> <!-- closing of container div -->

<?php include 'include/footer.php';
