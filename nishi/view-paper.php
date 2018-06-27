<?php session_start();

//We don't need other files here.
include 'include/db.php';

//fetch given ID from request.
$id = $_REQUEST['paper_id'];

if(!$id) {
  $_SESSION['error_msg'] = 'Sorry but you can not view this paper.';
  echo header('Location: manage-question-paper.php');
}

//fetch paper from database.
$pdo = Database::connect();
$sql = "SELECT * FROM questionbank WHERE q_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($id));
$paper = $stmt->fetch();

  //if no paper found.
  if(!$paper) {
    $_SESSION['error_msg'] = 'No question paper found :(';
    echo header('Location: manage-question-paper.php');
  }

  //if no paper file uploaded.
  if($paper['question_file'] == null) {
    $_SESSION['error_msg'] = 'No Question paper file uploaded for this question paper :(';
    echo header('Location: manage-question-paper.php');
  }

//setting header type for file.
header("content-type:" .$paper['q_mime']);
echo $paper['question_file'];

?>
