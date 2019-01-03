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
if(isset($_POST['submit'])){
  if(isset($_POST['work_id'])){
		$query = $conn->prepare('SELECT work_id FROM staff_tb WHERE work_id = :work_id');
		$query->execute(array(':work_id' => $_POST['work_id']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['work_id'])){
			$error[] = 'Work ID provided is NOT in use.';
		}
	}
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO off_tb (work_id,off_type,days_avail,start_date,stop_date,days_req,notes,doc,approver) VALUES (:work_id, :off_type, :days_avail, :start_date, :stop_date, :days_req, :notes, :doc, :approver)');
			$query->execute(array(
				':work_id' => $_POST['work_id'],
				':off_type' => $_POST['type'],
				':days_avail' => $_POST['days_avail'],
				':start_date' => $_POST['date'],
                ':stop_date' => $_POST['date2'],
                ':days_req' => $_POST['days2'],
                ':notes' => $_POST['notes'],
                ':doc' => $_POST['file'],
                ':approver' => $_POST['approver']
			));
          
          header('Location: le-dayoff.php?action=off submited');
			exit;
          
          //send notification email to the user who applied
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
        <title>Day Off Application</title>
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
    <body><?php require ('le-nav-staff.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab card-4 left">
            <form class="u-form" method="post">
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
                <h1 >Apply for A Day Off</h1>
              <div class="col-md-7">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Work ID</span>
                        <input type="text" class="form-control" placeholder="Enter your Work ID" value="<?php echo $user->work_id; ?>" name="work_id" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Off Type</span>
                        <select name="type" id="sel2" class="form-control" title="Choose Leave Type">
                          <?php
                            echo '<option value="'.$rows['type'].'">'.$rows['type'].'</option>';
                            $result = $conn->prepare("SELECT * FROM def_off ORDER BY def_offid ASC");
                            $result->execute();
                            for($i=0; $row = $result->fetch(); $i++){
                              echo '<option value="'.$row[off_name].'">'.$row[off_name].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Days Available</span>
                        <input type="number" class="form-control" placeholder="Off Days Available" name="days_avail" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Start Date</span>
                        <input type="date" class="form-control" name="date" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Stop Date</span>
                        <input type="date" class="form-control" name="date2" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Days Requested</span>
                        <input type="number" class="form-control" placeholder="Off days Requested" name="days2" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">To be Approved by</span>
                        <select name="approver"  title="choose Approvers" class="form-control" id='sel2' required>
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
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Reason</span>
                        <textarea class="form-control" rows="4" id="comment" placeholder="Give Reason(s) For Application of this Off" name="notes" required></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">Supporting Doc</span>
                        <input type="file" class="form-control" name="file" required>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary le-btn" name="submit">SUBMIT OFF APPLICATION <i class="fa fa-send"></i></button>
                  </div>
                </div>
              </div>
            </form>
            <div class="col-md-5">
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
                          <th>Requested Days</th>
                          <th>Balance Days</th>
                        </tr>
                        <?php 
                        $result = $conn->prepare("SELECT * FROM def_off ORDER BY def_offid DESC");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <tr>
                          <td><?php echo $row['def_offid']; ?></td>
                          <td><?php echo $row['off_name']; ?></td>
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