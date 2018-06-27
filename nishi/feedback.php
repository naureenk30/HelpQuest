<?php
  //including header and session.
  include "include/header.php";
  include "include/db.php";

  if(isset($_SESSION['student_logged_in'])) {
    $_SESSION['error_msg'] = 'You are not allowed to access this page.';
    echo header("Location: index.php");
  }

  if(isset($_POST['sendFeedback'])) {
    //Form field values.
    $name = $_POST['feedbackName'];
    $email = $_POST['feedbackEmail'];
    $msg = $_POST['feedbackCmt'];

    $pdo = Database::connect();

    //How server respond back
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //try to save data
    try {
      // ?? are just to protect the site from SQL injections
      $sql = "INSERT INTO feedback (name, email, feedback) values(?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($name, $email, $msg));
      Database::disconnect();

      //Notifying user via alert if school added.
      $_SESSION['success_msg'] = 'Feedback sent successfully :)';

    } catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

  };

?>

<div class="container">

    <?php include 'include/alert.php';?>

    <a href="index.php" role="button" class="btn btn-md btn-primary"><i class="fas fa-arrow-circle-left"></i> Go back</a>
    <h1>Your feedback</h1>
    <p>
      Enter your Name, Email and Feedback below and send us. We will use your feedback to improve app.
    </p>

  <div class="row">
    <div class="col form-col" id="addFeedback">

      <form class="col-8" action="feedback.php" method="post">
        <div class="form-group">
          <label for="feedbackName">Name</label>
          <input type="text" id="feedbackName" class="form-control" placeholder="Enter your name" name="feedbackName" required>
        </div>

        <div class="form-group">
          <label for="feedbackEmail">Email</label>
          <input type="email" id="feedbackEmail" class="form-control" placeholder="Enter your email" name="feedbackEmail" required>
        </div>

        <div class="form-group">
          <label for="cmts">Feedback comment</label>
          <textarea id="cmts" class="form-control" name="feedbackCmt" placeholder="Provide your feedback info..."></textarea>
        </div>

        <div class="form-group">
          <button type="submit" name="sendFeedback" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Send my feedback</button>
          <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
        </div>
    </form>
    </div>
  </div>

</div> <!-- closing of container div -->

<?php include 'include/footer.php';
