<?php
require __DIR__ . '/database.php';
$conn = db();
if(isset($_POST['approve'])){
  try{
    $off_id=$_GET['off_id'];

    //query updates off_tb 
    $query = $conn->prepare("UPDATE off_tb SET status = 'APPROVED' WHERE off_id = :off_id");
    $query->bindParam(':off_id', $off_id);
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
        <form method="post">
          <h4>Confirm Approval</h4>
          <input type="submit"  name="approve" class="btn btn-primary" value="APPROVE OFF DAYS">
          <input type="button"  name="" class="btn btn-default" onclick="window.history.back()" value="GO BACK">
        </form>
      </div>
    </div>
  </div>
</div>
