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
        <title>Complains/Concerns</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!--style-->
        <style>
          .input['type=text']{width: 400px;}
          .Off-tab{margin: 0 auto 26px auto;}
        </style>
    </head>
    <body>
      <?php require ('le-nav-admin.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <form method="post" class="u-form">
              <h1>Complains Tamplete</h1>
              <div class="clo-md-12">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <tbody>
                      <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>About</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                      <?php 
                      $result = $conn->prepare("SELECT * FROM complains_tb WHERE status = 'SHOW' ORDER BY complains_id DESC");
		              $result->execute();
		              for($i=0; $row = $result->fetch(); $i++){ ?>
                      <tr>
                        <td><?php echo $row['complains_id']; ?></td>
                        <td><?php echo $row['c_type']; ?></td>
                        <td><?php echo $row['c_about']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                          <a href="hide-comp.php?complains_id=<?php echo $row['complains_id']; ?>"><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash-o"></i> Hide</button></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>