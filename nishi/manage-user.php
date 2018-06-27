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
  <h2> Manage Superusers: </h2>
  <p>
    Click on help guide to understand how to manage user.
  </p><br>

    <a href="add-user.php" role="button" class="btn btn-md btn-primary">
      <i class="fa fa-plus-circle"></i>
      Add new Superuser
    </a>

    <button type="button" class="btn btn-md btn-info" data-toggle="modal" data-target="#helpGuide"><i class="fa fa-info-circle"></i> Help guide</button>

    <!-- Help guide modal -->
    <div class="modal fade bd-example-modal-lg" id="helpGuide" tabindex="-1" role="dialog" aria-labelledby="helpGuide" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="helpGuide">Help guide to manage Superuser.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ul>
                <li>You can't delete yourself, once you logged into your account.</li>
                <li>If you are admin you can't downgrade yourself to Superuser.</li>
                <li>You can upgrade any super user to admin by clicking on button 'Upgrade to admin' in front of given Superuser.</li>
                <li>Once you upgraded super user to admin you can revert back that user to super user by clicking on 'Revert to super user' button in front of given admin actions.</li>
                <li>Hover over disabled button to get more information.</li>
              </ul>
            </div>
          </div>
        </div>
        </div>
    <!-- ENd help modal -->

  <div class="row">
    <div class="col data-col" id="viewSchools">
        <table class="table">
          <thead class="thead-dark">
            <tr>
            <th scope="col">User Name</th>
            <th scope="col">User Email </th>
            <th scope="col">School Name</th>
            <th scope="col">User Role</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

              <?php
              try {
              //Fething all schools from database.
              $pdo = Database::connect();
              //We also have to disply school assigned with user, we will use LEFT join query here.
              $sql = "SELECT t1.user_id, t1.name, t1.email, t1.password, t1.is_admin, t1.is_superUser, t1.is_student, t2.school_name
                      FROM user_info AS t1 LEFT JOIN school AS t2
                      ON t1.school_id = t2.school_id ORDER BY user_id";
              ?>

              <?php foreach($pdo->query($sql) as $user) :?>
                <tr>
                  <th scope="row"> <?php echo $user['name'] ?> </th>
                  <td> <?php echo $user['email'] ?> </td>
                  <td>
                    <?php echo $user['school_name']?>
                    <?php if(empty($user['school_name'])):?>
                      -- not available --
                    <?php endif;?>
                  </td>
                  <td>
                    <?php if($user['is_admin']):?>
                      <span class="badge badge-primary">Admin</span>
                    <?php elseif($user['is_student']):?>
                      <span class="badge badge-warning">Student</span>
                    <?php else:?>
                      <span class="badge badge-secondary">Super User</span>
                    <?php endif;?>
                  </td>

                  <td> <!-- action table column -->

                    <?php if($user['is_student']):?>
                      <button class="btn btn-md btn-primary" title="You can not edit student." disabled>
                          <i class="far fa-edit"></i>
                      </button>
                    <?php else:?>
                      <a href="edit-user.php?id=<?php echo $user['user_id'] ?>" role="button" class="btn btn-md btn-primary">
                          <i class="far fa-edit"></i>
                      </a>
                    <?php endif;?>

                    <!-- user delete action -->
                    <?php if($user['user_id'] == $_SESSION['admin_logged_in']):?>
                      <button type="button" title="You can not delete yourselef!" class="btn btn-danger" disabled>
                        <i class="fa fa-trash-alt"></i>
                      </button>

                    <?php else:?>

                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser<?php echo $user['user_id']?>">
                        <i class="fa fa-trash-alt"></i>
                      </button>
                    <?php endif;?>

                    <!-- buttons for upgrade -->

                    <?php if($user['is_admin'] && $user['user_id'] !== $_SESSION['admin_logged_in'] ):?>
                      <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#revertUser<?php echo $user['user_id']?>">Revert to Super User</button>
                    <?php elseif($user['user_id'] == $_SESSION['admin_logged_in']):?>
                      <button class="btn btn-md btn-danger" title="You are admin, you can not downgrade yourself to superuser" disabled>Can't make Super User</button>
                    <?php elseif($user['is_student']):?>
                      <button class="btn btn-primary" title="Student can not be upgraded to admin and super user" disabled>Upgrade student</button>
                    <?php else:?>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upgradeUser<?php echo $user['user_id']?>"> Upgrade to admin </button>
                    <?php endif;?>

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
                                  Email - <b> <?php echo $user['email'] ?> </b><br>

                                  <?php if($user['school_id']):?>
                                    &amp; School Name - <b> <?php echo $user['school_name'] ?> </b>
                                  <?php else:?>
                                    &amp; Name - <b> <?php echo $user['name'];?>
                                  <?php endif;?>

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

                        <!-- Model for upgrade user -->
                        <!-- Modal -->
                          <div class="modal fade" id="upgradeUser<?php echo $user['user_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  Are you sure you want to upgrade <b><u> <?php echo $user['name']?></u></b> to Admin?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="upgrade-to-admin.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Yes, Upgrade to admin</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        <!-- Ending upgrade window -->


                        <!-- Model for downgrding user -->
                        <!-- Modal -->
                          <div class="modal fade" id="revertUser<?php echo $user['user_id']?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  Are you sure you want to downgrade <b><u> <?php echo $user['name']?></u></b> to super user?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                  <form class="inline-form" action="downgrade-user.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Yes, Downgrade to super user</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        <!-- Ending upgrade window -->

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
