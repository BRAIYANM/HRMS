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
        <title>Leave Approval</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
      <script src="js/argiepolicarpio.js" type="text/javascript" charset="utf-8"></script>
      <script src="js/application.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
      <div id="nav-bar">
        <ul class="nav-details">
          <li class="scroll"><a href=""><?php echo $user->username;?></a></li>
          <li class="scroll"><a href="le-approve.php">Pending</a></li>
          <li class="scroll"><a href="le-approved.php">Approved</a></li>
          <li class="scroll active"><a href="#">History</a></li>
          <li class="scroll"><a href="logout.php">Log out</a>
          </li>
        </ul>
      </div>
      <div class="well approve-details">
        <div class="form-head">
          <p class="p2">History of All Leaves</p>
        </div>
        <input type="text" name="filter" value="" id="filter" placeholder="Search Transaction..." autocomplete="off" />
          <table id="myTable" cellspacing="0" cellpadding="2">
            <thead>
              <th width="7%"> Work Id </th>
              <th width="10%"> Leave Type </th>
              <th width="10%"> Available </th>
              <th width="10%"> Start </th>
              <th width="10%"> Stop </th>
              <th width="10%"> Requested </th>
              <th width="25%"> Comments </th>
              <th width="10%"> Approved By </th>
            </thead>
            <tbody>
    <?php	
		$result = $conn->prepare("SELECT * FROM leavetb ORDER BY leaveid DESC");
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
	<tr class="record">
		<td><?php echo $row['workid']; ?></td>
		<td><?php echo $row['type']; ?></td>
		<td><?php echo $row['days_avail']; ?></td>
		<td><?php echo $row['startdt']; ?></td>
		<td><?php echo $row['stopdt']; ?></td>
		<td><?php echo $row['days_req']; ?></td>
		<td><?php echo $row['notes']; ?></td>
		<td><?php echo $row['approver']; ?></td>
	</tr>
	<?php
		}
	?>
            </tbody>
          </table>
        <?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
          ?>
      </div><br><br><br><br><br><br>

      
      <script src="js/jquery.js"></script>
  <?php
require('footer.php');
?>