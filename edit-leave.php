<?php
require __DIR__ . '/database.php';
$conn = db();

    $off_id=$_GET['off_id'];
	$result = $conn->prepare("SELECT * FROM off_tb WHERE off_id= :off_id");
	$result->bindParam(':off_id', $off_id);
	$result->execute();
	for($i=0; $rows = $result->fetch(); $i++){
?>
<form action="edit.php" method="post">
  <input type="hidden" name="memids" value="<?php echo $off_id; ?>" />
  Start Date<br>
  <input type="text" name="startdt" value="<?php echo $rows['start_date']; ?>" /><br><br>
  Stop Date<br>
  <input type="text" name="stopdt" value="<?php echo $rows['stop_date']; ?>" /><br><br>
  Days Requested<br>
  <input type="text" name="days_req" value="<?php echo $rows['days_req']; ?>" /><br><br>
  <input type="submit" value="Save" />
</form>
<?php
	}
?>