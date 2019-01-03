<?php
session_start();

if(empty($_SESSION['staffid']))
{
    header("Location: index.php");
}

require __DIR__ . '/database.php';
$conn = db();

require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$user = $app->UserDetails($_SESSION['staffid']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Staff Comments</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
    </head>
    <body>
      <div id="nav-bar">
        <ul class="nav-details">
          <li class="web-name scroll"><a href="le-manager.php">HRMS</a></li>
          <!--<li class="scroll"><a href=""><?php #echo $user->username;?></a></li>-->
          <li class="scroll"><a href="le-prof-man.php">My Profile</a></li>
          <li class="scroll active"><a href="#">Comments</a></li>
          <li class="scroll"><a href="le-approve.php">Pending</a></li>
          <li class="scroll "><a href="le-approved.php">Approved</a></li>
          <li class="scroll "><a href="le-disc-man.php">Disciplinary</a></li>
          <li class="scroll"><a href="le-comp-man.php">Complains</a></li>
          <li class="scroll"><a href="logout.php">Log out</a></li>
        </ul>
      </div>
      
      <?php require('footer.php'); ?>