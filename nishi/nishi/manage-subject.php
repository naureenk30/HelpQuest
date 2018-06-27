<?php session_start();
      include 'include/db.php';
      include 'include/header.php';
      include 'include/navbar.php';

      //if logged in user is super user then redirect to home page.
      if(isset($_SESSION['supper_user_logged_in'])) {
        $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
        echo header ("Location: index.php");
      }
?>

<div class="container">
  <?php include 'include/alert.php';?>
  <h2> Manage subjects: </h2>
    <a href="add-subject.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new subject
    </a>

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">Subject Name</th>
            <th scope="col">Subject Code </th>
            <th scope="col">Subject description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

              <?php

              try {
              //Fething all schools from database.
              $pdo = Database::connect();

              //We also have to disply school assigned with user, we will use LEFT join query here.
              $sql = "SELECT * FROM subject ORDER BY injected_date DESC";
              ?>

              <?php foreach($pdo->query($sql) as $sub) :?>
                <tr>
                  <th scope="row"> <?php echo $sub['sub_name'] ?> </th>
                  <td> <?php echo $sub['sub_code'] ?> </td>
                  <td> <?php echo $sub['sub_desc'] ?> </td>
                  <td>
                    <a href="edit-subject.php?sub_id=<?php echo $sub['sub_id'] ?>" role="button" class="btn btn-md btn-primary">
                      <i class="far fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteSub<?php echo $sub['sub_id']?>">
                      <i class="fa fa-trash-alt"></i>
                    </button>

                        <!-- Model for showing confirm to delete window -->
                        <!-- Modal -->
                            <div class="modal fade" id="deleteSub<?php echo $sub['sub_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete subject confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Are you sure you want to delete Subject with
                                  Name: <b> <?php echo $sub['sub_name'] ?> (<?php echo $sub['sub_code'];?>)</b>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="delete-subject.php" method="post">
                                    <input type="hidden" name="sub_id" value="<?php echo $sub['sub_id']?>">
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

              <?php
              // If above query fail.
              } catch(PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
              }
            ?>

        </tbody>
    </table>

    </div>
  </div> <!-- closing of row div -->
</div> <!-- closing of container div -->

<?php include 'include/footer.php';?>
