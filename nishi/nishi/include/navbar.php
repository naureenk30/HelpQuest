<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#00aded;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav nav-fill w-100">

      <?php if(!isset($_SESSION['logged_in'])) {
        echo header('Location: login.php');
      }
      ?>

      <?php if(isset($_SESSION['logged_in']) && !isset($_SESSION['admin_logged_in']) && !isset($_SESSION['supper_user_logged_in'])):?>
        <li class="nav-item">
          <a href="" class="nav-link">You are student, Download our app.</a>
        </li>
      <?php endif;?>

      <?php if(isset($_SESSION['supper_user_logged_in'])):?>

        <li class="nav-item active">
          <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="add-question-paper.php">Add question paper </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="manage-question-paper.php">Manage question paper </a>
        </li>

      <?php endif;?>

      <?php if(isset($_SESSION['admin_logged_in'])):?>

        <li class="nav-item active">
          <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home </a>
        </li>

        <!-- School dropdown menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            School
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-school.php">Add school</a>
            <a class="dropdown-item" href="manage-school.php">Manage school</a>
          </div>
        </li>

        <!-- user dropdown menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users"></i> Users
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-user.php"><i class="fa fa-user-plus"></i> Add user</a>
            <a class="dropdown-item" href="manage-user.php"><i class="fa fa-user-times"></i> Manage users</a>
          </div>
        </li>

        <!-- Subject dropdown menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Subjects
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-subject.php">Add subject</a>
            <a class="dropdown-item" href="manage-subject.php">Manage subjects</a>
          </div>
        </li>

        <!-- Question type dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Question type
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-question-type.php">Add question type</a>
            <a class="dropdown-item" href="manage-question-type.php">Manage question type</a>
          </div>
        </li>


        <!-- academic degree menu -->
        <li class="nav-item dropdown" id="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fa fa-graduation-cap"></i>  Academic degree
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-degree.php"><i class="fa fa-plus-circle"></i> Add academic degree</a>
            <a class="dropdown-item" href="manage-degree.php"><i class="fa fa-times-circle"></i> Manage academic degree</a>
          </div>
        </li>

        <!-- question paper menu -->
        <li class="nav-item dropdown" id="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Question paper
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-question-paper.php">Add question paper</a>
            <a class="dropdown-item" href="manage-question-paper.php">Manage question paper</a>
          </div>
        </li>

      <?php endif;?>

      <?php if(isset($_SESSION['logged_in'])):?>

        <li class="nav-item">
            <a role="button" class="btn btn-danger btn-md" href="logout.php"> <i class="fa fa-sign-out-alt"></i> Logout</a>
        </li>

      <?php endif;?>

    </ul>
  </div>
</nav>
