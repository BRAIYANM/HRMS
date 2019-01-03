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


if(isset($_POST['comment'])){
  if(isset($_POST['c_work_id'])){
		$query = $conn->prepare('SELECT work_id FROM staff_tb WHERE work_id = :work_id');
		$query->execute(array(':work_id' => $_POST['c_work_id']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['work_id'])){
			$error[] = 'Work ID provided is NOT in use.';
		}
	}
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO comments_tb (c_work_id, c_message, c_doc, c_approver) VALUES (:c_work_id, :c_message, :c_doc, :c_approver)');
			$query->execute(array(
              ':c_work_id' => $_POST['c_work_id'],
              ':c_message' => $_POST['c_message'],
              ':c_doc' => $_POST['c_doc'],
              ':c_approver' => $_POST['c_approver']
			));
          header('Location: le-disc-man.php?action=comment submited');
			exit;
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
}
if(isset($_POST['disc'])){
  if(isset($_POST['d_work_id'])){
		$query = $conn->prepare('SELECT work_id FROM staff_tb WHERE work_id = :work_id');
		$query->execute(array(':work_id' => $_POST['d_work_id']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['work_id'])){
			$error[] = 'Work ID provided is NOT in use.';
		}
	}
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO discipline_tb (d_work_id, d_message, d_doc, d_overseer) VALUES (:d_work_id, :d_message, :d_doc, :d_overseer)');
			$query->execute(array(
              ':d_work_id' => $_POST['d_work_id'],
              ':d_message' => $_POST['d_message'],
              ':d_doc' => $_POST['d_doc'],
              ':d_overseer' => $_POST['d_overseer']
			));
          header('Location: le-disc-man.php?action=comment submited');
			exit;
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Disciplinary Issues</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    </head>
    <body><?php require('le-nav-man.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <?php if (isset($error)) { ?>
                    <div class="col-lg-12">
                        <div class="alert alert-dismissable alert-danger">
                            <button data-dismiss="alert" class="close" type="button">x</button>
                            <p><strong>Error: </strong>
                              <?php foreach($error as $error){
                                echo $error; 
                                }
                              ?></p>
                        </div>
                        <div style="height: 10px;">&nbsp;</div>
                    </div>
                <?php } ?>
            <form method="post" class="u-form">
              <div class="col-md-6">
                <h2>Conduct Comments</h2>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Work ID</span>
                    <input type="text" class="form-control" placeholder="Enter User's Work ID" name="c_work_id" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Comment</span>
                    <textarea class="form-control" rows="4" id="comment" placeholder="Comments on achievements or personality of the staff member" name="c_message" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Supporting Doc</span>
                    <input type="file" class="form-control" name="c_doc" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Approved by</span>
                    <select name="c_approver"  title="choose Approver" class="form-control" id='sel2' required>
                      <option ></option>
                      <option value='FINANCE' >Finance Manager</option>
                      <option value='ACTURIAL' >Acturial Manager</option>
                      <option value='IT'>IT Manager</option>
                      <option value='HR' >HR Manager</option>
                      <option value='SALES' >Sales Manager</option>
                      <option value="MARKETING">Marketing Manager</option>
                    </select>
                  </div>
                </div>
                <button class="btn btn-primary le-btn" name="comment">COMMENT ON STAFF'S CONDUCT</button>
              </div>
            </form>
            <form method="post" class="u-form">
              <div class="col-md-6">
                <h2>Disciplinary Records</h2>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Work ID</span>
                    <input type="text" class="form-control" placeholder="Enter User's Work ID" name="d_work_id" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Message</span>
                    <textarea class="form-control" rows="4" id="comment" placeholder="Give details of the wrong(s) done and disciplinary action(s) if any..." name="d_message" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Supporting Doc</span>
                    <input type="file" class="form-control" name="d_doc" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Overseed by</span>
                    <select name="d_overseer"  title="choose Approver" class="form-control" id='sel2' required>
                      <option ></option>
                      <option value='FINANCE' >Finance Manager</option>
                      <option value='ACTURIAL' >Acturial Manager</option>
                      <option value='IT'>IT Manager</option>
                      <option value='HR' >HR Manager</option>
                      <option value='SALES' >Sales Manager</option>
                      <option value="MARKETING">Marketing Manager</option>
                    </select>
                  </div>
                </div>
                <button class="btn btn-primary le-btn" name="disc">RECORD DISCIPLINARY ISSUES</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>