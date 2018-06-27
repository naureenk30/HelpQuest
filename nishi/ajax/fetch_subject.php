<?php
  include('../include/db.php');

  //getting school_id from request.
  if (isset($_POST['school_id'])) {

   $school_id = $_POST['school_id'];

   $pdo = Database::connect();
   $stmt = $pdo->prepare("SELECT * FROM subject WHERE school_id = ?");
   $stmt->execute(array($school_id));
   $subjects = $stmt->fetchAll();
 }
?>

   <option selected="selected"> -- select one subject -- </option>
   <?php foreach ($subjects as $s):?>
     <option value="<?php echo $s['sub_id']; ?>"><?php echo $s['sub_name']; ?></option>
   <?php endforeach;?>
