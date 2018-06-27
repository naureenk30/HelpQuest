<?php
//Including header, navbar and database connection files.
session_start();
include "include/header.php";
include "include/navbar.php";
include "include/db.php";


  //Codes to add new subject
  //Initially set all field values to null
  $sub_name = null;
  $sub_code = null;
  $sub_desc = null;
  $sub_cmt = null;

  //fetch schools.
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $res = $pdo->prepare("SELECT school_id, school_name FROM school");
  $res->execute();
  $schools = $res->fetchAll();
Database::disconnect();
//fetch years.
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $res = $pdo->prepare("SELECT y_id, y_name FROM year");
  $res->execute();
  $years = $res->fetchAll();


  //If fields have value and form submitted
  if(isset($_POST['addSubject'])) {
    //Form field values.
    $sub_name = $_POST['subjectName'];
    $sub_code = $_POST['subjectCode'];
    $sub_desc = $_POST['subjectDesc'];
    $sub_cmt = $_POST['subjectCmt'];
    $school_id = $_POST['school_id'];
    $y_id = $_POST['y_id'];

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO subject (sub_name, sub_code, sub_desc, school_id,y_id, comments) values(?, ?, ?, ?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($sub_name, $sub_code, $sub_desc, $school_id,$y_id, $sub_cmt));

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
          <label for="subjectName">Enter subject name:</label>
          <input id="subjectName" type="text" class="form-control" placeholder="Subject name" name="subjectName" required>
        </div>
        <div class="form-group">
          <label for="subjectCode">Enter subject code:</label>
          <input id="subjectCode" type="text" class="form-control" placeholder="Subject code" name="subjectCode" required>
        </div>

        <div class="form-group">
          <label for="schoolId">Select one school:</label>
          <select id="schoolId" class="form-control" name="school_id">
            <option value="">-- select one school --</option>
            <?php foreach($schools as $school):?>
              <option value="<?php echo $school['school_id'];?>"> <?php echo $school['school_name'];?> </option>
            <?php endforeach;?>
            </select>
          </div>

<div class="form-group">
          <label for="yId">Select Intermediate year:</label>
          <select id="yId" class="form-control" name="y_id">
            <option value="">-- select one year --</option>
            <?php foreach($years as $year):?>
              <option value="<?php echo $year['y_id'];?>"> <?php echo $year['y_name'];?> </option>
            <?php endforeach;?>
            </select>
          </div>


        <div class="form-group">
          <label for="subjectDesc">Enter subject description:</label>
          <input id="subjectDesc" type="text" class="form-control" placeholder="Enter subject description" name="subjectDesc" required>
        </div>
        <div class="form-group">
          <label for="subjectCmt">Enter subject comment:</label>
          <textarea id="subjectCmt" class="form-control" placeholder="Enter subject comments..." name="subjectCmt"></textarea>
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
