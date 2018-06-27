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
            $sql = "SELECT * FROM user_info where user_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

    ?>

<div class="container">

  <h1>Edit User</h1>
  <p>
    Edit the information of user filled in below form and click on save button to update the school information.
    In case you want to update password enter new password, if you don't want to change
    user school then don't do anything else change and save.
  </p>

  <a href="add-user.php" role="button" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Add new user</a>
  <a href="manage-user.php" role="button" class="btn btn-md btn-secondary"><i class="fa fa-eye"></i> View users</a>

    <div class="row">
      <div class="col col-8 data-col">

        <?php include 'include/alert.php';?>

        <form method="post" action="update-user.php">

          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="name" name="userName" class="form-control" id="name" value="<?php echo $data['name']?>" required>
          </div>

          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="userEmail" class="form-control" id="email" value="<?php echo $data['email']?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password"
                   name="userPassword"
                   class="form-control" id="password"
                   value="<?php echo $data['password'];?>">
          </div>

          <div class="form-group">
            <label for="admin">Make this user <b> Admin </b> </label>
            <select class="form-control" name="admin" id="admin">
              <option value="null">--Select one option--</option>
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>

          <div class="form-group">
            <label for="school_id"> Select school of user </label>
              <select class="form-control" name="school_id" id="school_id">

                <option class="form-control" value="<?php echo $data['school_id'];?>"> Keep previous selected school </option>

              <?php //fetch all school to show in form.
                    $pdo = Database::connect();
                    $sql = "SELECT * FROM school";?>

              <?php foreach($pdo->query($sql) as $school) :?>
                  <option class="form-control" value="<?php echo $school['school_id'];?>">
                    <?php echo $school['school_name'];?>
                  </option>
              <?php endforeach; ?>

            </select>
          </div>

          <div class="form-group">
            <!-- Sending school ID to update in post request -->
            <input type="hidden" name="user_id" value="<?php echo $data['user_id']?>">
            <button type="submit" name="updateUser" class="btn btn-md btn-success"><i class="fas fa-upload"></i> Update user </button>
            <a href="manage-user.php" role="button" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</a>
          </div>
        </form>

      </div>
    </div>

</div>

<?php include('include/footer.php');
