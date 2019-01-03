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
        <title>Leave Status</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    </head>
    <body><?php require ('le-nav-staff.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <h1>LEAVE & OFF BALANCES</h1>
            <div class="col-md-8">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Leave Transactions</h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Leave Type</th>
                          <th>Start Date</th>
                          <th>Stop Date</th>
                          <th>Requested</th>
                          <th>Status</th>
                          <th>Applied On</th>
                        </tr>
                        <?php 
                        $result = $conn->prepare("SELECT * FROM leave_tb WHERE work_id = '$user->work_id' ORDER BY leave_id DESC");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <tr>
                          <td><?php echo $row['leave_id']; ?></td>
                          <td><?php echo $row['leave_type']; ?></td>
                          <td><?php echo $row['start_date']; ?></td>
                          <td><?php echo $row['stop_date']; ?></td>
                          <td><?php echo $row['days_req']; ?></td>
                          <td><?php echo $row['status']; ?></td>
                          <td><?php echo $row['applied_at']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Leave Days</h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Leave Type</th>
                          <th>Default Days</th>
                        </tr>
                        <?php 
                        $result = $conn->prepare("SELECT * FROM def_leave ORDER BY def_leaveid DESC");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <tr>
                          <td><?php echo $row['def_leaveid']; ?></td>
                          <td><?php echo $row['leave_name']; ?></td>
                          <td><?php echo $row['def_days']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Off Transactions</h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Off Type</th>
                          <th>Start Date</th>
                          <th>Stop Date</th>
                          <th>Requested</th>
                          <th>Status</th>
                          <th>Applied On</th>
                        </tr>
                        <?php 
                        $result = $conn->prepare("SELECT * FROM off_tb WHERE work_id = '$user->work_id' ORDER BY off_id DESC");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <tr>
                          <td><?php echo $row['off_id']; ?></td>
                          <td><?php echo $row['off_type']; ?></td>
                          <td><?php echo $row['start_date']; ?></td>
                          <td><?php echo $row['stop_date']; ?></td>
                          <td><?php echo $row['days_req']; ?></td>
                          <td><?php echo $row['status']; ?></td>
                          <td><?php echo $row['applied_at']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Off Days</h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Off Type</th>
                          <th>Default Days</th>
                        </tr>
                        <?php 
                        $result = $conn->prepare("SELECT * FROM def_off ORDER BY def_offid DESC");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <tr>
                          <td><?php echo $row['def_offid']; ?></td>
                          <td><?php echo $row['off_name']; ?></td>
                          <td><?php echo $row['def_days']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php require('footer.php'); ?>