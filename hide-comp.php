<?php
require __DIR__ . '/database.php';
$conn = db();
if(isset($_POST['approve'])){
  try{
    $complains_id=$_GET['complains_id'];

    //query updates leave_tb 
    $query = $conn->prepare("UPDATE complains_tb SET status = 'HIDE' WHERE complains_id = :complains_id");
    $query->bindParam(':complains_id', $complains_id);
    $query->execute();
    //header("Location :le-approve.php?action=off approved");
    //exit;
  }catch(PDOException $e) {
      $error[] = $e->getMessage();
  }
  
}

require('header.php');
?>
<div class="container">
  <div class="col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>Hide Form</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post">
          <h4>Confirm Action</h4>
          <input type="submit" name="approve" class="btn btn-primary" value="HIDE COMPLAIN">
          <input type="button"  name="" class="btn btn-default" onclick="window.history.back()" value="GO BACK">
        </form>
      </div>
    </div>
  </div>
</div>
