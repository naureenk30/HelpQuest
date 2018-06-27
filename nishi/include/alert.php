<?php if(isset($_SESSION['errors'])):?>
  <!-- When multiple errors to show -->
  <div class="alert error_msg alert-dismissible fade show" role="alert">
          <?php foreach($_SESSION['errors'] as $err):?>
            <li><?php echo $err;?></li>
          <?php endforeach;?>
          <?php unset($_SESSION['errors']);?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif;?>

<?php if(isset($_SESSION['success_msg'])):?>
  <!-- When only one success message to show -->
  <div class="alert success_msg alert-dismissible fade show" role="alert">
      <b> Info: </b> <?php echo $_SESSION['success_msg'];?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <?php unset($_SESSION['success_msg']); ?>
  </div>
<?php endif;?>

<?php if(isset($_SESSION['error_msg'])):?>
  <!-- When only one error to show -->
  <div class="alert success_msg alert-dismissible fade show" role="alert">
      <b> Error: </b> <?php echo $_SESSION['error_msg'];?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <?php unset($_SESSION['error_msg']); ?>
  </div>
<?php endif;?>
