<?php
    //Including header, navbar and database connection files.
    session_start();
    include "include/header.php";
    include "include/navbar.php";
    include "include/db.php";
    //to store errors.
    $errors = array();
    //fetch schools.
    $pdo = Database::connect();
    $sth = $pdo->prepare("SELECT school_id, school_name FROM school");
    $sth->execute();
    $schools = $sth->fetchAll();
    //fetch question types.
    $sth = $pdo->prepare("SELECT qt_id, qt_name FROM questiontype");
    $sth->execute();
    $qt = $sth->fetchAll();
    //Adding paper.
    if(isset($_POST['addPaper'])) {
      //Set a variable to track form.
      $valid = true;
      //get valur from form.
      $school_id = $_POST['school_id'];
      $sub_id = $_POST['sub_id'];
      $ad_id = $_POST['ad_id'];
      $qt_id = $_POST['qt_id'];
      $intermidiate_year = $_POST['intermediate_year'];
      $q_year = $_POST['q_year'];
      $question_desc = $_POST['question_desc'];
      $answer_desc = $_POST['answer_desc'];
      //Check if user upload any question paper file.
      if($_FILES['question_file']['name'] == '') {
        //show error to user.
        $errors[] = "You must select Question Paper file.";
        $valid = false;
      } else {
        //Find out name and type of question paper file.
        $question_file_name = $_FILES['question_file']['name'];
        $question_file_type = $_FILES['question_file']['type'];
        //encode file into blob format.
        $question_file = file_get_contents($_FILES['question_file']['tmp_name']);
        $valid = true;
      }
      //Check if user upload any answer sheet file.
      if($_FILES['answer_file']['name'] == '') {
        //If no answer sheet uploaded then set values to null;
        $answer_file = $answer_file_type = $answer_file_name = null;
        $valid = true;
      } else {
        //Find out name and type of answer sheet.
        $answer_file_name = $_FILES['answer_file']['name'];
        $answer_file_type = $_FILES['answer_file']['type'];
        //encode file into blob format.
        $answer_file = file_get_contents($_FILES['answer_file']['tmp_name']);
        $valid = true;
      }
      //if uploaded files are not pdf.
      if($question_file_type !== 'application/pdf') {
        $errors[] = 'Only PDF files can be uploaded as paper.';
        $valid = false;
      }
      if($answer_file_type !== 'application/pdf') {
        $errors[] = 'Only pdf files are allowed in answer key.';
        $valid = false;
      }
        //check if any error in form.
        if($valid == true) {
            //try to save form
            //If everything fine submit data into form;
            try {
              $pdo = Database::connect();
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "INSERT into questionbank (school_id, intermediate_year, sub_id, ad_id, question_desc, question_file, q_mime, answer_desc, answer_file, a_mime, qt_id, q_year, question_file_name, answer_file_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
              $stmt = $pdo->prepare($sql);
              $paper = $stmt->execute(array($school_id, $intermidiate_year, $sub_id, $ad_id, $question_desc, $question_file, $question_file_type, $answer_desc, $answer_file, $answer_file_type, $qt_id, $q_year, $question_file_name, $answer_file_name));
              //if paper added successfully.
              if($paper) {
                $_SESSION['success_msg'] = 'Paper added successfully, you can view and delete it from manage papers menu.';
              } else {
                $errors[] = 'Error: Something went wrong, failed to add paper.';
              }
            } catch(PDOException $e) {
              $errors[] = 'Paper not saved in database.';
            }
        } else {
          $errors[] = 'There are some error please fill entire form before saving.';
        }
    }
    if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
    }
?>

  <div class="container">

    <?php include 'include/alert.php';?>

    <div class="alert alert-success" role="alert">
    <h1> Add new question paper </h1>
        1. Size of Question and answer key pdf <u>must not be bigger then <b>1 MB</b></u> <br>
        2. Make sure you have enough data before adding paper. You have to select School, Degree, Subject, Year, Question type,
        Question paper (pdf), Answer sheet (pdf) etc.
    </div>

    <script type="text/javascript">
          // After fetching school we will use AJAX with PHP to dynamically fetch subject and degree associated with selected school
        $(document).ready(function() {
          //check if user selected any school
         $("#schoolName").change(function() {
           var school_id = $(this).val();
           var dataString = 'school_id='+ school_id;
           //Sending ajax request.
            $.ajax ({
             type: "POST",
             url: "ajax/fetch_degree.php",
             data: dataString,
             success: function(html) {
                //outputing all degree related to selected school.
                $("#degreeName").html(html);
             }
            });
          });
          //once user also selected school also fetch subjects.
           $("#schoolName").change(function() {
            var school_id = $(this).val();
            var dataString = 'school_id='+ school_id;
            $.ajax ({
             type: "POST",
             url: "ajax/fetch_subject.php",
             data: dataString,
             cache: false,
             success: function(html) {
              $("#subjectName").html(html);
             }
            });
          });
        });
      </script>

    <div class="row form-col">

      <form action="add-question-paper.php" class="col-md-12" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="schoolName">School Name:</label>
            <select class="form-control" id="schoolName" name="school_id" required>

                <option value=""> -- Select one school --</option>

              <?php foreach($schools as $school):?>
                <option value="<?php echo $school['school_id'];?>"> <?php echo $school['school_name'];?> </option>
              <?php endforeach;?>

            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="subjectName">Subject</label>
            <select class="form-control" id="subjectName" name="sub_id" required>

                <option value="" selected> -- select school first --</option>

            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="degreeName">Degree Name:</label>
            <select class="form-control" id="degreeName" name="ad_id" required>

                <option class="select-degree" value=""> -- select school first --</option>

            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="questionType">Question type</label>
            <select class="form-control" id="questionType" name="qt_id" required>

                <option value="">-- Select one question type -- </option>

              <?php foreach($qt as $q):?>
                <option value="<?php echo $q['qt_id'];?>"> <?php echo $q['qt_name'];?> </option>
              <?php endforeach;?>

            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="intYear">Intermediate Year:</label>
            <select class="form-control" id="intYear" name="intermediate_year" required>
              <option value="">-- Select your intermediate year --</option>
              <option value="1st">1st</option>
              <option value="2nd">2nd</option>
              <option value="3rd">3rd</option>
              <option value="4th">4th</option>
              <option value="5th">5th</option>
              <option value="6th">6th</option>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="paperYear">Question Paper Year:</label>
              <select class="form-control" id="paperYear" name="q_year" required>
                <option value="">-- Select year --</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
              </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="paperDesc">Question Paper Description</label>
              <textarea id="paperDesc" name="question_desc" class="form-control" placeholder="Enter detailed question paper description..."></textarea>
          </div>

          <div class="form-group col-md-6">
            <label for="answerDesc">Answer Sheet Description</label>
            <textarea id="answerDesc" name="answer_desc" class="form-control" placeholder="Enter detailed answer sheet description..."></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="paperFile">Question paper file</label>
            <input id="paperFile" class="form-control" type="file" accept="application/pdf" name="question_file">
          </div>

          <div class="form-group col-md-6">
            <label for="answerFile">Answer sheet file</label>
            <input id="answerFile" class="form-control" type="file" accept="application/pdf" name="answer_file">
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-md btn-success" name="addPaper"><i class="fa fa-plus-circle"></i> Add new question paper</button>
          <button type="reset" class="btn btn-md btn-danger" name="reset"><i class="fa fa-history"></i> Reset form fields</button>
        </div>

      </form>
    </div>

  </div> <!-- closing of container div -->

<?php include 'include/footer.php';
