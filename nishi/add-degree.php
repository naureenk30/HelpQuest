<?php
  //Including header, navbar and database connection files.
  session_start();
  include "include/header.php";
  include "include/navbar.php";
  include "include/db.php";

  //fetch schools.
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $res = $pdo->prepare("SELECT school_id, school_name FROM school");
  $res->execute();
  $schools = $res->fetchAll();

  //if logged in user is super user then redirect to home page.
  if(isset($_SESSION['supper_user_logged_in'])) {
    $_SESSION['error_msg'] = 'You are not allowed to access this page.';
    echo header("Location: index.php");
  }

  //If fields have value and form submitted
  if(isset($_POST['addDegree'])) {
    //Form field values.
    $ad_name = $_POST['adName'];
    $ad_desc = $_POST['adDesc'];
    $comments = $_POST['adCmt'];
    $school_id = $_POST['school_id'];

    //Find name of logged in user from session.
    $user_name = $_SESSION['admin_name'];
    $date = Date('d-m-y');

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO academic_degree (ad_name, ad_desc, school_id, comments) values(?, ?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($ad_name, $ad_desc, $school_id, $comments));
      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'Academic degree added successfully :)';

        //get the name of selected school.
        $sql = "SELECT * FROM school WHERE school_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($school_id));
        $school_data = $q->fetchAll();

        //If degree added also add activity record.
          $user_id = $_SESSION['admin_logged_in'];
          $action_name = "A new degree <b> " . $ad_name . " </b>
                          was added in school name - <b> " . $school_data['school_name'] . "
                          and description <b> " . $school_data['school_desc'] . " </b>.";
          $sql2 = "INSERT INTO user_activities (date_time, user_id, action_name) values (?, ?, ?)";
          $q2 = $pdo->prepare($sql2);
          $q2->execute(array($date, $user_id, $action_name));

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
          <label for="school_id">Select school:</label>
          <select class="form-control" name="school_id" required>
              <option value=""> -- Select one school -- </option>
              <?php foreach($schools as $school):?>
                <option value="<?php echo $school['school_id']['school_name'];?>"> <?php echo $school['school_name'];?> </option>
              <?php endforeach;?>
          </select>
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
