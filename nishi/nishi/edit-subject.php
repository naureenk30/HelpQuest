<?php
          session_start();
          include 'include/header.php';
          include 'include/navbar.php';
          include 'include/db.php';

            //Initially setting id value to null
            $sub_id = null;

            //Fethch ID given in URL
            if ( !empty($_GET['sub_id'])) {
                $sub_id = $_REQUEST['sub_id'];
            }

            //if no subject ID given.
            if(!isset($_GET['sub_id'])) {
              $_SESSION['error_msg'] = 'Your request is not valid, Enjoy empty form :)';
            }

            //Fetch data from database and fill form with data.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM subject where sub_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($sub_id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

    ?>

<div class="container">

  <h1>Edit SUbject</h1>
  <p>
    Change info and click on Update Subject.
  </p>

  <a href="add-subject.php" role="button" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Add new subject</a>
  <a href="manage-subject.php" role="button" class="btn btn-md btn-secondary"><i class="fa fa-eye"></i> View subjects</a>

    <div class="row">
      <div class="col col-8 data-col">

        <?php include 'include/alert.php';?>

        <form method="post" action="update-subject.php">
          <div class="form-group">
            <label for="subName">Subject Name:</label>
            <input type="text" id="subName" name="subName" class="form-control" value="<?php echo $data['sub_name']?>">
          </div>
          <div class="form-group">
            <label for="subCode">Subject Code:</label>
            <input type="text" id="subCode" name="subCode" class="form-control" value="<?php echo $data['sub_code']?>">
          </div>
          <div class="form-group">
            <label for="subDesc">Subject Description:</label>
            <input type="text" id="subDesc" name="subDesc" class="form-control" value="<?php echo $data['sub_desc']?>">
          </div>
          <div class="form-group">
            <label for="subCmt">Additional Comments:</label>
            <textarea name="subCmt" id="subCmt" class="form-control"><?php echo $data['comments']?></textarea>
          </div>
          <div class="form-group">
            <!-- Sending school ID to update in post request -->
            <input type="hidden" name="sub_id" value="<?php echo $data['sub_id']?>">
            <button type="submit" name="updateSub" class="btn btn-md btn-success"><i class="fas fa-upload"></i> Update subject </button>
            <a href="manage-subject.php" role="button" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</a>
          </div>
        </form>

      </div>
    </div>

</div>

<?php include('include/footer.php');
