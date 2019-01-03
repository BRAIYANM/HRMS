<?php
require __DIR__ . '/database.php';
$conn = db();
if(isset($_POST['approve'])){
  try{
    $leave_id=$_GET['leave_id'];

    //query updates leave_tb 
    $query = $conn->prepare("UPDATE leave_tb SET status = 'DECLINED' WHERE leave_id = :leave_id");
    $query->bindParam(':leave_id', $leave_id);
    $query->execute();
    
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
        <h3>Approve Form</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post">
          <h4>Confirm to Decline</h4>
          <input type="submit" name="approve" class="btn btn-primary" value="DECLINE LEAVE DAYS">
          <input type="button"  name="" class="btn btn-default" onclick="window.history.back()" value="GO BACK">
        </form>
      </div>
    </div>
  </div>
</div>