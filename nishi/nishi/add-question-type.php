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

  //if logged in user is super user then redirect to home page.
  if(isset($_SESSION['supper_user_logged_in'])) {
    $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
    echo header ("Location: index.php");
  }

  //If fields have value and form submitted
  if(isset($_POST['addQT'])) {
    //Form field values.
    $qt_name = $_POST['qtName'];
    $qt_desc = $_POST['qtDesc'];
    $comments = $_POST['qtCmt'];

    $pdo = Database::connect();

    //How server respond back
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO questiontype (qt_name, qt_desc, comments) values(?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($qt_name, $qt_desc, $comments));
      Database::disconnect();

      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'Question type added successfully :)';

    } catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

  };

?>

<div class="container">

    <?php include 'include/alert.php';?>

    <h1>Add new Question Type</h1>
    <p>
      Enter Question type name, description and additional comments and save.
    </p>

  <div class="row">
    <div class="col form-col" id="addQT">

      <form class="col-8" action="add-question-type.php" method="post">
        <div class="form-group">
          <label for="qtName">Question type name</label>
          <input type="text" id="qtName" class="form-control" placeholder="Enter question type name" name="qtName" required>
        </div>

        <div class="form-group">
          <label for="qtDesc">Question type description</label>
          <input type="text" id="qtDesc" class="form-control" placeholder="Enter question type description" name="qtDesc" required>
        </div>

        <div class="form-group">
          <label for="cmts">Comments</label>
          <textarea id="cmts" class="form-control" name="qtCmt"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" name="addQT" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Add new question type</button>
          <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
        </div>
    </form>
    </div>
  </div>

</div> <!-- closing of container div -->

<?php include 'include/footer.php';
