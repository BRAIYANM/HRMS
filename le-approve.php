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
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="css/facebox.css" rel="stylesheet" type="text/css">
    </head>
    <body><?php require('le-nav-man.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <h1>APPROVAL TAB</h1>
            <div class="col-md-6">
              <h2><span class="badge">
          <?php
            $stmt = $conn->prepare("SELECT * FROM leave_tb WHERE status = 'PENDING' AND approver = '$user->department''");
            $stmt->execute();
            echo $stmt->rowCount();
          ?>
          </span> Leave Approval</h2>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Work ID</th>
                      <th>Type</th>
                      <th>Start</th>
                      <th>Stop</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM leave_tb WHERE status = 'PENDING' AND approver = '$user->department' ORDER BY leave_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['leave_id']; ?></td>
                      <td><?php echo $row['work_id']; ?></td>
                      <td><?php echo $row['leave_type']; ?></td>
                      <td><?php echo $row['start_date']; ?></td>
                      <td><?php echo $row['stop_date']; ?></td>
                      <td>
                        <a href="app-leave.php?leave_id=<?php echo $row['leave_id']; ?>"><button class="btn btn-sm btn-info" type="button" title="Approve"><i class="fa fa-check"></i></button></a>
                        <a href="decline-leave.php?leave_id=<?php echo $row['leave_id']; ?>"><button class="btn btn-sm btn-danger" type="button" title="Decline"><i class="fa fa-trash-o"></i></button></a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            
            <div class="col-md-6">
              <h2><span class="badge">
          <?php
            $stmt = $conn->prepare("SELECT * FROM off_tb WHERE status = 'PENDING' AND approver = '$user->department''");
            $stmt->execute();
            echo $stmt->rowCount();
          ?>
          </span> Off Approval</h2>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Work ID</th>
                      <th>Type</th>
                      <th>Start</th>
                      <th>Stop</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM off_tb WHERE status = 'PENDING' AND approver = '$user->department' ORDER BY off_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['off_id']; ?></td>
                      <td><?php echo $row['work_id']; ?></td>
                      <td><?php echo $row['off_type']; ?></td>
                      <td><?php echo $row['start_date']; ?></td>
                      <td><?php echo $row['stop_date']; ?></td>
                      <td>
                        <a href="app-off.php?off_id=<?php echo $row['off_id']; ?>"><button class="btn btn-sm btn-info" type="button" title="Approve"><i class="fa fa-check"></i></button></a>
                        <a href="decline-off.php?off_id=<?php echo $row['off_id']; ?>"><button class="btn btn-sm btn-danger" type="button" title="Decline"><i class="fa fa-trash-o"></i></button></a>
                      </td>
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