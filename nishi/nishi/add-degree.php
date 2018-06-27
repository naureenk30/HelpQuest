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

  //If fields have value and form submitted
  if(isset($_POST['addDegree'])) {
    //Form field values.
    $ad_name = $_POST['adName'];
    $ad_desc = $_POST['adDesc'];
    $comments = $_POST['adCmt'];

    $pdo = Database::connect();

    //How server respond back
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO academic_degree (ad_name, ad_desc, comments) values(?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($ad_name, $ad_desc, $comments));
      Database::disconnect();

      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'Academic degree added successfully :)';

    } catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

  };

?>

<div class="container">

    <?php include 'include/alert.php';?>

    <h1>Add new Academic degree</h1>
    <p>
      Enter Academic degree name, description, comments and click on save button.
    </p>

  <div class="row">
    <div class="col form-col" id="addQT">

      <form class="col-8" action="add-degree.php" method="post">
        <div class="form-group">
          <label for="adName">Academic degree name</label>
          <input type="text" id="adName" class="form-control" placeholder="Enter name of degree" name="adName" required>
        </div>

        <div class="form-group">
          <label for="adDesc">Academic degree description</label>
          <input type="text" id="adDesc" class="form-control" placeholder="Enter description of degree" name="adDesc" required>
        </div>

        <div class="form-group">
          <label for="cmts">Degree Comments</label>
          <textarea id="cmts" class="form-control" name="adCmt"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" name="addDegree" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Add new academic degree</button>
          <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
        </div>
    </form>
    </div>
  </div>

</div> <!-- closing of container div -->

<?php include 'include/footer.php';
