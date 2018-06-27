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

  //Codes to add new subject
  //Initially set all field values to null
  $sub_name = null;
  $sub_code = null;
  $sub_desc = null;
  $sub_cmt = null;

  //If fields have value and form submitted
  if(isset($_POST['addSubject'])) {
    //Form field values.
    $sub_name = $_POST['subjectName'];
    $sub_code = $_POST['subjectCode'];
    $sub_desc = $_POST['subjectDesc'];
    $sub_cmt = $_POST['subjectCmt'];

    $pdo = Database::connect();

    //How server respond back
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO subject (sub_name, sub_code, sub_desc, comments) values(?, ?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($sub_name, $sub_code, $sub_desc, $sub_cmt));
      Database::disconnect();

      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'Subject added successfully :)';

    } catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

  };

?>

<div class="container">

    <?php include 'include/alert.php';?>

    <h1>Add new subject</h1>
    <p>
      Fill the subject name, subject code, subject description and subject comments and click
      on add new subject.
    </p>

  <div class="row">
    <div class="col form-col" id="addSubject">

      <form class="col-8" action="add-subject.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter subject name" name="subjectName" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter subject code" name="subjectCode" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter subject description" name="subjectDesc" required>
        </div>
        <div class="form-group">
          <textarea class="form-control" placeholder="Enter subject comments..." name="subjectCmt"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" name="addSubject" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Add new subject</button>
          <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
        </div>
    </form>
    </div>
  </div>

</div> <!-- closing of container div -->

<?php include 'include/footer.php';
