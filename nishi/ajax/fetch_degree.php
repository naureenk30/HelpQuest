  <?php
    include('../include/db.php');

    //getting school_id from request.
    if (isset($_POST['school_id'])) {

     $school_id = $_POST['school_id'];

     $pdo = Database::connect();
     $stmt = $pdo->prepare("SELECT * FROM academic_degree WHERE school_id = ?");
     $stmt->execute(array($school_id));
     $degree = $stmt->fetchAll();
   }
 ?>

     <option selected="selected"> -- select one degree -- </option>
     <?php foreach ($degree as $d):?>
       <option value="<?php echo $d['ad_id']; ?>"><?php echo $d['ad_name']; ?></option>
     <?php endforeach;?>
