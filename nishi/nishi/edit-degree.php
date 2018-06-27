<?php
          session_start();
          include 'include/header.php';
          include 'include/navbar.php';
          include 'include/db.php';


            //Fethch ID given in URL
            if ( !empty($_GET['ad_id'])) {
                $ad_id = $_REQUEST['ad_id'];
            }

            //Fetch data from database and fill form with data.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM academic_degree where ad_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($ad_id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

    ?>

<div class="container">

  <h1>Edit Academic degree</h1>
  <p>
    Edit Name, Description or add new comments and save.
  </p>

  <a href="add-degree.php" role="button" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Add new degree</a>
  <a href="manage-degree.php" role="button" class="btn btn-md btn-secondary"><i class="fa fa-eye"></i> View all degree</a>

    <div class="row">
      <div class="col col-8 data-col">

        <?php include 'include/alert.php';?>

        <form method="post" action="update-degree.php">

          <div class="form-group">
            <label for="adName">Degree Name</label>
            <input type="text" name="adName" class="form-control" id="adName" value="<?php echo $data['ad_name']?>" required>
          </div>

          <div class="form-group">
            <label for="adDesc">Degree description</label>
            <input type="text" name="adDesc" class="form-control" id="adDesc" value="<?php echo $data['ad_desc']?>" required>
          </div>

          <div class="form-group">
            <label for="cmts">Comments</label>
            <textarea name="adCmts" class="form-control" id="cmts"><?php echo $data['comments'];?></textarea>
          </div>

          <div class="form-group">
            <input type="hidden" name="ad_id" value="<?php echo $data['ad_id']?>">
            <button type="submit" name="updateDegree" class="btn btn-md btn-success"><i class="fas fa-upload"></i> Update degree </button>
            <a href="manage-degree.php" role="button" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</a>
          </div>
        </form>

      </div>
    </div>

</div>

<?php include('include/footer.php');
