<?php
require __DIR__ . '/database.php';
$conn = db();

	$id=$_GET['leaveid'];
	$result = $conn->prepare("DELETE FROM leapprove WHERE leaveid= :leaveid");
	$result->bindParam(':leaveid', $leaveid);
	$result->execute();
?>