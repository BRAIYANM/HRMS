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
<?php

$sql = "SELECT id, title, start, end, color FROM events ";

$req = $conn->prepare($sql);
$req->execute();

$events = $req->fetchAll();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Page</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href='css/jquery-ui.css' rel='stylesheet' >
      
      <!-- Custom CSS -->
      <style>
      #main{min-height: 487px;}
        body {padding-top: 64px;}
         .side-details {
          overflow:hidden;
          position:absolute !important;
          display:none;
        }
        @media only screen and (min-width :1100px) {
          #sidemenu {width:200px;display:block;}
        }
        .col-dash{margin: 10px;background-color: #ffffff}
        .well{border:3px solid #0ca3d2;border-radius: 4px;}
        body{background-color: #f1f1f1;}
      </style>
    </head>
    <body><?php require('le-nav-home.php'); ?>
      <nav class="side-details animate-left card-2 side-nav" id="sidemenu">
        <a href="javascript:void(0)" onclick="side_close()" class="closebtn">&times;</a><br>
        <h2>Menus</h2>
        <a href="le-profile.php"><i class="fa fa-photo"></i> My Profile</a>
        <a href="le-status.php"><i class="fa fa-bar-chart-o"></i> Balances</a>
        <a href="le-apply.php"><i class="fa fa-file-code-o"></i> Leave Applicaion</a>
        <a href="le-dayoff.php"><i class="fa fa-file-code-o"></i> Day Off Application</a>
        <a href="le-comp-user.php"><i class="fa fa-comment"></i> Complains</a>
      </nav>
      <div id="main">
        <div class="well card-8">
          <div class="row">
            <h1 class="usdash"><i class="fa fa-dashboard"></i> Dashboard<span class=""> Welcome, <?php echo $user->fname; ?> <i class="fa fa-user"></i></span></h1>
		      	<div class="col-md-7 col-dash card-4">
              <h2><i class="fa fa-bell-o"></i> Notifications</h2>
              <div class="table-responsive">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>TO</th>
                      <th>ABOUT</th>
                      <th>MESSAGE</th>
                    </tr>
                    <?php
                    $result = $conn->prepare("SELECT * FROM notification_tb ORDER BY notification_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){
                    ?>
                    <tr>
                      <td><?php echo $row['recipient']; ?></td>
                      <td><?php echo $row['about']; ?></td>
                      <td><?php echo $row['message']; ?></td>
                      <td></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-4 col-dash card-4">
              <h2><i class="fa fa-calendar-o"></i> My Calendar</h2>
              <div id="datepicker"></div> 
            </div>
          </div>
        </div>
      </div>
      <script src="js/custom.js" type="text/javascript"></script>
      <?php require('footer.php'); ?>