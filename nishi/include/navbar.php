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

      <?php
        //get URL of current page.
        $activePage = basename($_SERVER['PHP_SELF'], ".php");
       ?>

      <?php if(isset($_SESSION['student_log'])):?>
        <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
          <a href="index.php" class="nav-link">You are a student!</a>
        </li>

        <li class="nav-item <?= ($activePage == 'student-paper') ? 'active':''; ?>">
          <a class="nav-link" href="student-paper.php"><i class="fa fa-eye"> </i> View question & answer key </a>
        </li>
      <?php endif;?>

      <?php if(isset($_SESSION['supper_user_logged_in'])):?>

        <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
          <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home </a>
        </li>

        <li class="nav-item <?= ($activePage == 'add-question-paper') ? 'active':''; ?>">
          <a class="nav-link" href="add-question-paper.php"><i class="far fa-question-circle"> </i> Add question paper </a>
        </li>

        <li class="nav-item <?= ($activePage == 'manage-question-paper') ? 'active':''; ?>">
          <a class="nav-link" href="manage-question-paper.php"><i class="far fa-question-circle"> </i> Manage question paper </a>
        </li>

        <li class="nav-item <?= ($activePage == 'add-subject') ? 'active':''; ?>">
          <a class="nav-link" href="add-subject.php"><i class="fas fa-book"> </i> Add Subject </a>
        </li>

        <li class="nav-item <?= ($activePage == 'manage-subject') ? 'active':''; ?>">
          <a class="nav-link" href="manage-subject.php"><i class="fas fa-book"> </i> Manage Subject </a>
        </li>

        <li class="nav-item <?= ($activePage == 'feedback') ? 'active':''; ?>">
          <a class="nav-link" href="feedback.php"><i class="fab fa-font-awesome-alt"></i> Feedback </a>
        </li>

      <?php endif;?>

      <?php if(isset($_SESSION['admin_logged_in'])):?>

        <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
          <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home </a>
        </li>

        <!-- School dropdown menu -->
        <li class="nav-item dropdown <?= ($activePage == 'add-school') ? 'active':''; ?> <?= ($activePage == 'manage-school') ? 'active': '';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-university"> </i> School
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-school.php"><i class="fa fa-plus-circle"> </i> Add school</a>
            <a class="dropdown-item" href="manage-school.php"><i class="far fa-window-close"> </i> Manage school</a>
          </div>
        </li>

        <!-- user dropdown menu -->
        <li class="nav-item dropdown  <?= ($activePage == 'add-user') ? 'active':''; ?> <?= ($activePage == 'manage-user') ? 'active': '';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users"></i> Users
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-user.php"><i class="fa fa-user-plus"></i> Add user</a>
            <a class="dropdown-item" href="manage-user.php"><i class="fa fa-user-times"></i> Manage users</a>
          </div>
        </li>

        <!-- Subject dropdown menu -->
        <li class="nav-item dropdown  <?= ($activePage == 'add-subject') ? 'active':''; ?> <?= ($activePage == 'manage-subject') ? 'active': '';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-book"> </i> Subjects
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-subject.php"><i class="fa fa-plus-circle"> </i> Add subject</a>
            <a class="dropdown-item" href="manage-subject.php"><i class="far fa-window-close"> </i> Manage subjects</a>
          </div>
        </li>

        <!-- Question type dropdown -->
        <li class="nav-item dropdown  <?= ($activePage == 'add-question-type') ? 'active':''; ?> <?= ($activePage == 'manage-question-type') ? 'active': '';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-question-circle"> </i> Question type
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-question-type.php"><i class="fa fa-plus-circle"> </i> Add question type</a>
            <a class="dropdown-item" href="manage-question-type.php"><i class="far fa-window-close"> </i> Manage question type</a>
          </div>
        </li>


        <!-- academic degree menu -->
        <li class="nav-item dropdown  <?= ($activePage == 'add-degree') ? 'active':''; ?> <?= ($activePage == 'manage-degree') ? 'active': '';?>" id="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fa fa-graduation-cap"></i>  Academic degree
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-degree.php"><i class="fa fa-plus-circle"></i> Add academic degree</a>
            <a class="dropdown-item" href="manage-degree.php"><i class="far fa-window-close"> </i> Manage academic degree</a>
          </div>
        </li>

        <!-- question paper menu -->
        <li class="nav-item dropdown <?= ($activePage == 'add-question-paper') ? 'active':''; ?> <?= ($activePage == 'manage-question-paper') ? 'active': '';?>" id="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-question-circle"> </i> Question paper
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="add-question-paper.php"><i class="fa fa-plus-circle"> </i> Add question paper</a>
            <a class="dropdown-item" href="manage-question-paper.php"><i class="far fa-window-close"> </i> Manage question paper</a>
          </div>
        </li>

        <li class="nav-item <?= ($activePage == 'manage-feedback') ? 'active':''; ?>">
          <a class="nav-link" href="manage-feedback.php"><i class="fab fa-font-awesome-alt"></i> Manage Feedback </a>
        </li>

      <?php endif;?>

      <?php if(isset($_SESSION['logged_in'])):?>

        <li class="nav-item logout-item">
            <a class="nav-link" href="logout.php"> <i class="fa fa-sign-out-alt"></i> Logout</a>
        </li>

      <?php endif;?>

    </ul>
  </div>
</nav>
