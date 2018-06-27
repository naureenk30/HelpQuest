<?php session_start();
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
    <h1>View &amp; Manage Question papers.</h1>
    <p>
      A list of all paper from database, with all important information. You can view question paper, answer sheet (if uploaded) and delete them from database.
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
              Click on view button to view the paper in your browser.
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

              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePaper<?php echo $paper['QUESTION_ID'];?>"><i class="fa fa-trash"></i> Delete paper</button>

              <div class="modal fade" id="deletePaper<?php echo $paper['QUESTION_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      You are about to remove this paper, are you sure??
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <form class="inline-form paper-link" action="delete-paper.php" method="post">
                        <input type="hidden" name="paper_id" value="<?php echo $paper['QUESTION_ID'];?>">
                        <button type="submit" name="deletePaper" class="btn btn-danger"> Yes, Delete it!</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

          </div>
        </div>

        <?php endforeach;?>

      </div>
    </div>
  </div>

<?php include 'include/footer.php';?>
