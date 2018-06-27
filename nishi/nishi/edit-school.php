<?php
          session_start();
          include 'include/header.php';
          include 'include/navbar.php';
          include 'include/db.php';

          //Initially setting id value to null
          $id = null;

            //Fethch ID given in URL
            if ( !empty($_GET['id'])) {
                $id = $_REQUEST['id'];
            }

            //Fetch data from database and fill form with data.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM school where school_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

    ?>

<div class="container">

  <h1>Edit School</h1>
  <p>
    Edit the information of school filled in below form and click on save button to update the school information.
  </p>

  <a href="add-school.php" role="button" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Add new school</a>
  <a href="manage-school.php" role="button" class="btn btn-md btn-secondary"><i class="fa fa-eye"></i> View schools</a>

    <div class="row">
      <div class="col col-8 data-col">

        <?php include 'include/alert.php';?>

        <form method="post" action="update-school.php">
          <div class="form-group">
            <input type="text" name="schoolName" class="form-control" value="<?php echo $data['school_name']?>">
          </div>
          <div class="form-group">
            <input type="text" name="schoolDesc" class="form-control" value="<?php echo $data['school_desc']?>">
          </div>
          <div class="form-group">
            <textarea name="schoolCmt" class="form-control"><?php echo $data['comments']?></textarea>
          </div>
          <div class="form-group">
            <!-- Sending school ID to update in post request -->
            <input type="hidden" name="school_id" value="<?php echo $data['school_id']?>">
            <button type="submit" name="updateSchool" class="btn btn-md btn-success"><i class="fas fa-upload"></i> Update school </button>
            <a href="manage-school.php" role="button" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</a>
          </div>
        </form>

      </div>
    </div>

</div>

<?php include('include/footer.php');
