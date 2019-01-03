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

//sending the complain|concern
if(isset($_POST['submit_com'])){
    try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO complains_tb (c_type, c_about, message) VALUES (:c_type, :c_about, :message)');
			$query->execute(array(
				':c_type' => $_POST['type'],
				':c_about' => $_POST['about'],
				':message' => $_POST['message']
			));
          
          header('Location: le-comp-man.php?action=concern/complain submited');
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
        <title>Complains/Concerns</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!--style-->
        <style>
          
        </style>
    </head>
    <body><?php require('le-nav-man.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <form method="post" class="u-form">
              <h1>Please submit your Complain or Concerns here.</h1>
              <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Type</span>
                    <select id="sel2" class="form-control" name="type" title="Choose Type" required>
                      <option></option>
                      <option>Complain</option>
                      <option>Concern</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Receiver</span>
                    <input type="text" class="form-control" value="Administrator" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">About</span>
                    <input type="text"  class="form-control" name="about" placeholder="What the message is about, ie. Heading" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Message</span>
                    <textarea class="form-control" rows="7" id="comment" placeholder="Details of the message to be sent" name="message" required></textarea>
                  </div>
                </div>
                
                <input type="submit" name="submit_com" class="btn btn-primary" value="SUBMIT COMPLAIN | CONCERN">
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>