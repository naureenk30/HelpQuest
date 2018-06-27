<?php //session_start();
      include 'include/db.php';
      include 'include/header.php';
      include 'include/navbar.php';

      //fetch all papers.
      $pdo = Database::connect();
      $stmt = $pdo->prepare("SELECT * FROM questionbank_v");
      $stmt->execute();
      $data = $stmt->fetchAll();
?>

  <div class="container">

    <?php include 'include/alert.php';?>

    <?php if(empty($data)):?>
      <!-- If no paper -->
      <?php include('include/no-data.php');?>
    <?php endif;?>

    <?php if($data):?>
    <h1>View  Question papers.</h1>
    <p>
      A list of all paper from database, with all important information. You can view question paper, answer sheet (if uploaded).
    </p>

    <div class="row">
      <div class="col col-md-12">

        <?php foreach($data as $paper):?>
        <div class="card paper-card text-secondary border-primary">
          <div class="card-header">
            Question paper
          </div>
          <div class="card-body">
            <h5 class="card-title">
              Question paper from school <b><u><?php echo $paper['SCHOOL_NAME'];?></u></b> for subject
              <b><u><?php echo $paper['SUBJECT_NAME'];?></u></b>
            </h5>
            <p class="card-text">
              <p>Academic degree: <b>
                                  <?php echo $paper['ACADEMIC_NAME'];?>
                                  (<?php echo $paper['INTERMEDIATE_YEAR'];?> year, <?php echo $paper['QUESTION_TYPE_NAME'];?>, <?php echo $paper['QUESTION_YEAR'];?>)
                                </b>
              </p>
                Click on view button to view the paper in your browser, if answer key button is not clickable means no answer keey uploaded for given paper.
              </p>
          </div>

          <div class="card-footer paper-links">

            <form class="inline-form paper-link" action="view-paper.php" method="post">
              <input type="hidden" name="paper_id" value="<?php echo $paper['QUESTION_ID'];?>">
              <button type="submit" name="viewPaper" class="btn btn-primary"><i class="fas fa-eye"></i> View paper</button>
            </form>

            <?php if($paper['ANSWER_FILE'] == null):?>
              <form class="inline-form paper-link" action="" method="post">
                <button class="btn btn-primary" title="Answer key is not available for this paper." disabled><i class="fas fa-eye"></i> View answer key</button>
              </form>
            <?php else:?>
              <form class="inline-form paper-link" action="view-answer-key.php" method="post">
                <input type="hidden" name="paper_id" value="<?php echo $paper['QUESTION_ID'];?>">
                <button type="submit" name="viewKey" class="btn btn-primary"><i class="fas fa-eye"></i> View answer key</button>
              </form>

            <?php endif;?>

          </div>
        </div>

        <?php endforeach;?>

      </div>
    </div>
  <?php endif;?>
  </div>

<?php include 'include/footer.php';?>
