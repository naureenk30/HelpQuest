<?php session_start();
        include "include/header.php";
        include "include/navbar.php";
        include "include/db.php";

        //if logged in user is super user then redirect to home page.
        if(isset($_SESSION['supper_user_logged_in'])) {
          $_SESSION['error_msg'] = 'Error: You are not allowed to access this page.';
          echo header ("Location: index.php");
        }

        //fetching all schools from database to show in form below.
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM school");
        $stmt->execute();
        //storing all schools.
        $schools = $stmt->fetchAll();

        //insert new user data.
        if (isset($_POST['addUser'])) {

        //variables
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //variable to store multiple errors.
        $errors = array();

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

        //if email is empty
        if(empty($_POST['email'])) {
          $errors[] = 'Please enter a valid email.';
          $valid = false;
        }

        //if password empty
        if(empty($_POST['password'])) {
          $errors[] = 'Please enter password.';
          $valid = false;
        }

        //if password is not strong.
        if(strlen($_POST['password']) < 6) {
          $errors[] = 'Password must be at least 6 characters long.';
          $valid = false;
        }

        //If no school selected.
        if(isset($_POST['school_id']) && $_POST['school_id'] == '0') {
          $errors[] = 'You must select one school';
          $valid = false;
        }

        //Check if email already exists in database.
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt->execute(array($email));
        $data = $stmt->rowCount();

          if($data) {
            $errors[] = 'This email already exist, please choose another one.';
            $valid = false;
          }

          if($valid) {
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
                    $errors[] = 'There was an error in saving user, please try again later.';
                    Database::disconnect();
                  }

                } catch(PDOException $e) {
                  $errors[] = $e->getMessage();
                }

        }

        //if page have errors store them in session.
        if(count($errors) > 0) {
          $_SESSION['errors'] = $errors;
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
                <label for="name">Enter Name:</label>
                <input type="text" id="name" class="form-control" placeholder="Enter the name" name="name" required>
              </div>
              <div class="form-group">
                <label for="email">Enter Email:</label>
                <input type="email" id="email" class="form-control" placeholder="Enter valid email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Enter password (Min. 6 characters long):</label>
                <input type="password" id="password" class="form-control" placeholder="Enter password" name="password" required>
              </div>
              <div class="form-group">
                <label for="school">Select one school:</label>
                <select class="form-control" name="school_id" required>
                <option class="form-control" value="0">-- Select one school --</option>

                  <?php foreach($schools as $school) :?>
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
