<?php
require __DIR__ . '/database.php';
$conn = db();

	$id=$_GET['staffid'];
	$result = $conn->prepare("DELETE FROM staffdb WHERE staffid= :staffid");
	$result->bindParam(':staffid', $staffid);
	$result->execute();
?>