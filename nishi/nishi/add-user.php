<?php session_start();
        include "include/header.php";
        include "include/navbar.php";
        include "include/db.php";

        //if logged in user is super user then redirect to home page.
        if(isset($_SESSION['supper_user_logged_in'])) {
          $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
          echo header ("Location: index.php");
        }

        //insert new user data.
        if(isset($_POST['addUser'])) {

        //variables
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Newly added user will be assign to super user.
        $superUser = true;
        $admin = false;
        $school_id = $_POST['school_id'];

        //geting current time fot injected_date field.
        $date = new DateTime();
        $injected_date = $date->format('U = Y-m-d H:i:s');

        //to check if no error to save final data.
        $valid = true;

        //encrypting password.
        $password = md5($password);

        //if email and password are empty
        if(empty($email) && empty($password) && empty($name)) {
          $_SESSION['error_msg'] = 'Please add name, email & password before saving user.';
          $valid = false;
        }

        //If no school selected.
        if(isset($_POST['school_id']) && $_POST['school_id'] == '0') {
          $_SESSION['error_msg'] = 'You must select one school';
          $valid = false;
        }

        //Check if email already exists in database.
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM user_info WHERE email = $email");
        $stmt->execute();
        $data = $stmt->fetch();

          if($data['email'] === $email) {
            $_SESSION['error_msg'] = 'This email already exist, please choose another one.';
            $valid = false;
          }

        if($valid = true) {

                try {
                  //save data
                  $pdo = Database::connect();
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sql = "INSERT INTO user_info (school_id, name, email, password, is_admin, is_superUser, injected_date) VALUES (?,?,?,?,?,?,?)";
                  $q = $pdo->prepare($sql);
                  $user = $q->execute(array($school_id, $name, $email, $password, $admin, $superUser, $injected_date));

                  //showing message to user if saved.
                  if($user) {
                    $_SESSION['success_msg'] = 'User saved successfully.';
                    Database::disconnect();
                  } else {
                    $_SESSION['error_msg'] = 'There was an error in saving user, please try again later.';
                    Database::disconnect();
                  }

                } catch(PDOException $e) {
                  $_SESSION['error_message'] = $e->getMessage();
                }

        } else {
          $_SESSION['error_msg'] = 'There are some error in form. All fields are required.';
        }

      }


?>

    <div class="container">
        <?php include 'include/alert.php';?>
        <h1>Add User</h1>
        <p>
          Enter Name, valid Email, Password and School to add new users. All new users will be assigned to <b>Super User</b> role, in edit
          section you can change user role to admin.
        </p>

        <div class="row">
          <div class="col form-col">

            <form class="col-8" action="add-user.php" method="post">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter the name" name="name" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Enter valid email" name="email" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter password" name="password" required>
              </div>
              <div class="form-group">
                <select class="form-control" name="school_id">
                <option class="form-control" value="0">-- Select one school --</option>

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
                <button type="submit" name="addUser" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> Add new user</button>
                <button type="reset" name="cancel" class="btn btn-md btn-danger"><i class="fas fa-history"></i> Cancel</button>
              </div>
          </form>
          </div>
        </div>

      </div> <!-- closing of container div -->

<?php include "include/footer.php";?>
