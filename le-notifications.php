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

//Posting a Notification
if(isset($_POST['submit_notify'])){
    try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO notification_tb (recipient, sender, about, message) VALUES (:recipient, :sender, :about, :message)');
			$query->execute(array(
				':recipient' => $_POST['recipient'],
				':sender' => $_POST['sender'],
				':about' => $_POST['about'],
				':message' => $_POST['message']
			));
          
          header('Location: le-notifications.php?action=notification posted');
			exit;
          
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Notify</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!--style-->
        <style>
          
        </style>
    </head>
    <body>
      <?php require ('le-nav-admin.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <form method="post" class="u-form">
              <h1><i class="fa fa-bell"></i> Notifications Tamplete</h1>
              <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Receiver Of The Notification</span>
                      <select id="sel2" class="form-control" name="recipient" title="Choose Receiver" required>
                        <option></option>
                        <option>All Users</option>
                        <option>Managers</option>
                        <option>Staff</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Sender Of The Notification</span>
                      <input type="text" class="form-control" placeholder="" name="sender" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Notification is About</span>
                      <input type="text" class="form-control" placeholder="" name="about" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Notification Massage</span>
                      <textarea class="form-control" rows="7" id="comment" name="message" required></textarea>
                    </div>
                </div>
              <input type="submit" name="submit_notify" class="btn btn-primary" value="SUBMIT NOTIFICATION">
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>