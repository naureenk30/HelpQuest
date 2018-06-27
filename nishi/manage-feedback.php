<?php session_start();
      include 'include/db.php';
      include 'include/header.php';
      include 'include/navbar.php';

      //if logged in user is super user then redirect to home page.
      if(isset($_SESSION['student_logged_in'])) {
        $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
        echo header ("Location: index.php");
      }

      if(isset($_SESSION['supper_user_logged_in'])) {
        $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
        echo header ("Location: index.php");
      }

      $pdo = Database::connect();
      $sql = "SELECT * FROM feedback ORDER BY id ASC";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $feedbacks = $stmt->fetchAll();
?>

<div class="container">

  <?php include 'include/alert.php';?>

  <?php if(empty($feedbacks)):?>
    <!-- If no schools -->
    <?php include('include/no-data.php');?>
  <?php endif;?>

  <?php if($feedbacks):?>
  <h2> Manage feedbacks: </h2>

  <div class="row">
    <div class="col data-col" id="viewSchools">

        <?php foreach($feedbacks as $f) :?>
          <div class="card" style="width: 100%;">
            <div class="card-body">
             <h6 class="card-subtitle mb-2 text-muted"><?php echo $f['name'];?> ( <?php echo $f['email'];?> )</h6>
              <p class="card-text">
                <b>Feedback: </b> <?php echo $f['feedback'];?>
              </p>
            </div>
          </div>

        <?php endforeach;?>

        </tbody>
    </table>

    </div>
  </div> <!-- closing of row div -->
<?php endif;?>
</div> <!-- closing of container div -->

<?php include 'include/footer.php';?>
