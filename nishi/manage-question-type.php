<?php session_start();
      include 'include/db.php';
      include 'include/header.php';
      include 'include/navbar.php';

      //if logged in user is super user then redirect to home page.
      if(isset($_SESSION['supper_user_logged_in'])) {
        $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
        echo header ("Location: index.php");
      }

      //Fething all schools from database.
      $pdo = Database::connect();

      //We also have to disply school assigned with user, we will use LEFT join query here.
      $sql = "SELECT * FROM questiontype ORDER BY injected_date DESC";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      $types = $stmt->fetchAll();
?>

<div class="container">

  <?php include 'include/alert.php';?>

  <?php if(empty($types)):?>
    <!-- If no question type -->
    <?php include('include/no-data.php');?>
  <?php endif;?>

  <?php if($types):?>
  <h2> Manage question types: </h2>

  <p>You can't edit Question types, It's better to add new.</p>

    <a href="add-question-type.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new question type
    </a>

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">Question type Name</th>
            <th scope="col">Question type Desc </th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>



              <?php foreach($types as $qt) :?>
                <tr>
                  <th scope="row"> <?php echo $qt['qt_name'] ?> </th>
                  <td> <?php echo $qt['qt_desc'] ?> </td>
                  <td>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteQt<?php echo $qt['qt_id']?>">
                      <i class="fa fa-trash-alt"></i> Delete
                    </button>

                        <!-- Model for showing confirm to delete window -->
                        <!-- Modal -->
                            <div class="modal fade" id="deleteQt<?php echo $qt['qt_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  Are you sure you want to delete
                                  <b> <?php echo $qt['qt_name'];?> </b>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="delete-type.php" method="post">
                                    <input type="hidden" name="qt_id" value="<?php echo $qt['qt_id']?>">
                                    <button type="submit" class="btn btn-danger">Yes, Delete it!</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                            </div>
                        <!-- Ending showing window -->

                  </td>
                </tr>
              <?php endforeach;?>

        </tbody>
    </table>

    </div>
  </div> <!-- closing of row div -->
<?php endif;?>
</div> <!-- closing of container div -->

<?php include 'include/footer.php';?>
