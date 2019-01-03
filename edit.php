<?php
require __DIR__ . '/database.php';
$conn = db();

//new data
$startdt = $_POST['startdt'];
$stopdt = $_POST['stopdt'];
$days_req = $_POST['days_req'];

//query
$query = $conn->prepare("UPDATE leapprove SET startdt=?, stopdt=?, days_req=? WHERE leaveid=?");
$query->execute(array(
  "startdt" => $startdt, 
  "stopdt" => $stopdt, 
  "days_req" => $days_req));
header("Location :le-approve.php");
?>