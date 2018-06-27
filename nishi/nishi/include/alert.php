<!-- Show alert messages -->

  <?php if(isset($_SESSION['error_msg'])):?>

    <div class="alert error_msg" role="alert">
        <?php  echo $_SESSION['error_msg'];
               unset($_SESSION['error_msg']);
        ?>
    </div>

  <?php elseif(isset($_SESSION['success_msg'])): ?>

    <div class="alert success_msg" role="alert">
          <?php  echo $_SESSION['success_msg'];
                 unset($_SESSION['success_msg']);
          ?>
    </div>

  <?php endif;?>

<!-- End showing alert messages -->
