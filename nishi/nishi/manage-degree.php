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

  <h2> Manage academic degree: </h2>
    <a href="add-degree.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new academic degree
    </a>

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">Degree Name</th>
            <th scope="col">Degree description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

              <?php

              try {
              //Fething all schools from database.
              $pdo = Database::connect();
              $sql = "SELECT * FROM academic_degree ORDER BY injected_date ASC";
              ?>

              <?php foreach($pdo->query($sql) as $ad) :?>
                <tr>
                  <th scope="row"> <?php echo $ad['ad_name'] ?> </th>
                  <td> <?php echo $ad['ad_desc'] ?> </td>
                  <td>
                    <a href="edit-degree.php?ad_id=<?php echo $ad['ad_id'] ?>" role="button" class="btn btn-md btn-primary">
                      <i class="far fa-edit"></i>
                      Edit degree
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteDegree<?php echo $ad['ad_id']?>">
                      <i class="fa fa-trash-alt"></i>
                      Delete
                    </button>

                        <!-- Model for showing confirm to delete window -->
                        <!-- Modal -->
                            <div class="modal fade" id="deleteDegree<?php echo $ad['ad_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete Academic Degree</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Are you sure you want to delete Academic degree
                                  Name: <b> <?php echo $ad['ad_name'] ?> </b>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="delete-degree.php" method="post">
                                    <input type="hidden" name="ad_id" value="<?php echo $ad['$ad_id']?>">
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
