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

  <h2> Manage school: </h2>
    <a href="add-school.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new school
    </a>

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">School Name</th>
            <th scope="col">School description</th>
            <th scope="col">School comment</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

              <?php

              try {
              //Fething all schools from database.
              $pdo = Database::connect();
              $sql = "SELECT * FROM school ORDER BY injected_date ASC";
              ?>

              <?php foreach($pdo->query($sql) as $school) :?>
                <tr>
                  <th scope="row"> <?php echo $school['school_name'] ?> </th>
                  <td> <?php echo $school['school_desc'] ?> </td>
                  <td> <?php echo $school['comments'] ?> </td>
                  <td>
                    <a href="edit-school.php?id=<?php echo $school['school_id'] ?>" role="button" class="btn btn-md btn-primary">
                      <i class="far fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteSchool<?php echo $school['school_id']?>">
                      <i class="fa fa-trash-alt"></i>
                    </button>

                        <!-- Model for showing confirm to delete window -->
                        <!-- Modal -->
                            <div class="modal fade" id="deleteSchool<?php echo $school['school_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete school confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Are you sure you want to delete this school with - <br>
                                  Title - <b> <?php echo $school['school_name'] ?> </b><br>
                                  Description - <b> <?php echo $school['school_desc'] ?> </b>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="delete-school.php" method="post">
                                    <input type="hidden" name="school_id" value="<?php echo $school['school_id']?>">
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
