<?php
  session_start();
  include('include/header.php');
  include('include/navbar.php');

  //If not logged in redirect back to login.
  if(!isset($_SESSION['logged_in'])) {
    $_SESSION['error_msg'] = 'You have to login in order to access the app.';
    echo header('Location: login.php');
  }
?>

<div class="container">

    <?php include 'include/alert.php';?>

    <?php if(isset($_SESSION['student_log'])):?>
      <div class="title">
           <h1> Welcome to <small>KIIT Question bank</small> </h1>
       </div>
       <br>
    <?php else:?>
      <div class="title text-center">
           <h1> Welcome to <br> <small>KIIT Question bank</small> </h1>
           <p>
             This site provides access to the <i>Admin</i> and <i>Superusers</i> for uploading question papers
             and managing super users of KIIT.
           </p>
           <h4>Services provided by KIIT :</h4>
       </div>
       <br>
    <?php endif;?>

    <?php if(isset($_SESSION['student_log'])):?>
      You are a student so you can only view question papers uploaded by college.
    <?php else:?>
      <div class="card-deck"> <!-- This will add equal heigh cards -->
        <!-- Group of 3 cards -->
          <div class="card card border-secondary mb-3">
                <h5 class="card-header">School</h5>
                <div class="card-body text-secondary">
                  <ol>
                    <li>To add school</li>
                    <li>To manage schools</li>
                    <li>Edit names of school</li>
                  </ol>
                </div>
            </div>

            <div class="card card border-secondary mb-3">
                <h5 class="card-header">Admin</h5>
                <div class="card-body text-secondary">
                  <ol>
                    <li>To add admin</li>
                    <li>To add superuser</li>
                    <li>To delete superuser</li>
                  </ol>
                </div>
            </div>

            <div class="card card border-secondary mb-3">
                <h5 class="card-header">Subjects</h5>
                <div class="card-body text-secondary">
                  <ol>
                    <li>To add subjects</li>
                    <li>To delete subject</li>
                    <li>To edit name &amp; subject code</li>
                  </ol>
                </div>
            </div>

          </div> <!-- End of first group -->

          <br> <!-- Give little space between card groups -->

          <div class="card-deck"> <!-- start of second group -->
            <div class="card card border-secondary mb-3">
                <h5 class="card-header">Question type</h5>
                <div class="card-body text-secondary">
                  <ol>
                    <li>Add question type</li>
                    <li>Edit question type</li>
                    <li>Delete question type</li>
                  </ol>
                </div>
            </div>

            <div class="card card border-secondary mb-3">
                <h5 class="card-header">Academic Degree</h5>
                <div class="card-body text-secondary">
                  <ol>
                    <li>Add type of course</li>
                    <li>Delete course</li>
                    <li>Edit name of course</li>
                  </ol>
                </div>
            </div>

          <div class="card card border-secondary mb-3">
              <h5 class="card-header">Question papers</h5>
              <div class="card-body text-secondary">
                <ol>
                  <li>Upload question papers</li>
                  <li>Remove question papers</li>
                </ol>
              </div>
          </div>

        </div> <!-- closing div tag of second group -->
    <?php endif;?>

  </div> <!-- closing tag of main container -->

<?php include('include/footer.php');?>
