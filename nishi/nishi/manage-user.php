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
  <h2> Manage users: </h2>
    <a href="add-user.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new user
    </a>

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">User Name</th>
            <th scope="col">User Email </th>
            <th scope="col">User School Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

              <?php

              try {
              //Fething all schools from database.
              $pdo = Database::connect();

              //We also have to disply school assigned with user, we will use LEFT join query here.
              $sql = "SELECT t1.user_id, t1.name, t1.email, t1.password, t2.school_name
                      FROM user_info AS t1 LEFT JOIN school AS t2
                      ON t1.school_id = t2.school_id ORDER BY user_id";
              ?>

              <?php foreach($pdo->query($sql) as $user) :?>
                <tr>
                  <th scope="row"> <?php echo $user['name'] ?> </th>
                  <td> <?php echo $user['email'] ?> </td>
                  <td> <?php echo $user['school_name'] ?> </td>
                  <td>
                    <a href="edit-user.php?id=<?php echo $user['user_id'] ?>" role="button" class="btn btn-md btn-primary">
                      <i class="far fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser<?php echo $user['user_id']?>">
                      <i class="fa fa-trash-alt"></i>
                    </button>

                        <!-- Model for showing confirm to delete window -->
                        <!-- Modal -->
                            <div class="modal fade" id="deleteUser<?php echo $user['user_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete user confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Are you sure you want to delete this user with - <br>
                                  Email - <b> <?php echo $user['name'] ?> </b><br>
                                  &amp; School Name - <b> <?php echo $user['school_name'] ?> </b>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="delete-user.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']?>">
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
