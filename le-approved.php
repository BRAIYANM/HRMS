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
        <title>Leave History</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!-- js -->
      <script src="js/argiepolicarpio.js" type="text/javascript" charset="utf-8"></script>
      <script src="js/application.js" type="text/javascript" charset="utf-8"></script>
      <!-- Style -->
      <style>
        
      </style>
    </head>
    <body><?php require('le-nav-man.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <h1>HISTORY TAB</h1>
            <div class="col-md-6">
              <h2>Leave History</h2>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Work ID</th>
                      <th>Type</th>
                      <th>Start</th>
                      <th>Stop</th>
                      <th>Status</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM leave_tb WHERE approver = '$user->department' ORDER BY leave_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['leave_id']; ?></td>
                      <td><?php echo $row['work_id']; ?></td>
                      <td><?php echo $row['leave_type']; ?></td>
                      <td><?php echo $row['start_date']; ?></td>
                      <td><?php echo $row['stop_date']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6">
              <h2>Off History</h2>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Work ID</th>
                      <th>Type</th>
                      <th>Start</th>
                      <th>Stop</th>
                      <th>Status</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM off_tb WHERE approver = '$user->department' ORDER BY off_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['off_id']; ?></td>
                      <td><?php echo $row['work_id']; ?></td>
                      <td><?php echo $row['off_type']; ?></td>
                      <td><?php echo $row['start_date']; ?></td>
                      <td><?php echo $row['stop_date']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            </div>
          </div>
        </div>
<?php require('footer.php'); ?>