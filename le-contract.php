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

//add a New User
if(isset($_POST['submit_contract'])){
  //checking whether the worrkid is in stafftb
  if(isset($_POST['work_id'])){
		$query = $conn->prepare('SELECT work_id FROM staff_tb WHERE work_id = :work_id');
		$query->execute(array(':work_id' => $_POST['work_id']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['work_id'])){
			$error[] = 'Work ID provided is NOT in use.';
		}
	}
  //insert data into staff_tb if there's no errors
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO contract_tb (c_work_id, job_name, start_date, stop_date, terms, approver) VALUES (:c_work_id, :job_name, :start_date, :stop_date, :terms, :approver)');
			$query->execute(array(
                ':c_work_id' => $_POST['work_id'],
                ':job_name' => $_POST['job_name'],
                ':start_date' => $_POST['start_date'],
                ':stop_date' => $_POST['stop_date'],
                ':terms' => $_POST['terms'],
                ':approver' => $_POST['approver']
                
			));
          
          header('Location: le-contract.php?action=contract submitted');
		  exit;
          
          //send notification email to the new user
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
}
if(isset($_POST['update_contract'])){
  //check branch name in the branch_tb
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
        $query = $conn->prepare("UPDATE contract_tb 
        SET c_work_id= :c_work_id, job_name= :job_name, start_date= :start_date, stop_date= :stop_date, terms= :terms, approver= :approver
        WHERE c_work_id= :c_work_id ");
        $query->bindParam(":c_work_id",$_POST['c_work_id']);
        $query->bindParam(":job_name",$_POST['job_name']);
        $query->bindParam(":start_date",$_POST['start_date']);
        $query->bindParam(":stop_date",$_POST['stop_date']);
        $query->bindParam(":terms",$_POST['terms']);
        $query->bindParam(":approver",$_POST['approver']);
        $query->execute();

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
        <title>Assigning Contracts</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    </head>
    <body>
      <?php require ('le-nav-admin.php'); ?>
      <div class="container">
        <div class="row">
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
          <div class="add-tab left card-4">
            <h1>CONTRACT TAB</h1>
            <form method="post" class="u-form">
              <div class="col-md-6">
                <h2>Enter A New Contract</h2>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Work ID</span>
                    <input type="text" class="form-control" placeholder="Enter User's Work ID" name="work_id" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Job Name</span>
                    <input type="text" class="form-control" placeholder="Enter Name of the Job" name="job_name" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Start Date</span>
                    <input type="date" class="form-control" name="start_date" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Stop Date</span>
                    <input type="date" class="form-control"name="stop_date" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Approved by</span>
                    <select name="approver"  title="choose Approver" class="form-control" id='sel2' required>
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
                    <span class="input-group-addon">Terms</span>
                    <textarea class="form-control" rows="4" id="comment" placeholder="State terms and conditions that were agreed upon" name="terms" required></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary le-btn" name="submit_contract">SUBMIT CONTRACT <i class="fa fa-send"></i></button>
              </div>
            </form>
            <form method="post" class="u-form">
              <div class="col-md-6">
                <h2>Update Existing Contract</h2>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Work ID</span>
                    <input type="text" class="form-control" placeholder="Enter User's Work ID" name="c_work_id" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Job Name</span>
                    <input type="text" class="form-control" placeholder="Enter Name of the Job" name="job_name" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Start Date</span>
                    <input type="date" class="form-control" name="start_date" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Stop Date</span>
                    <input type="date" class="form-control"name="stop_date" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Approved by</span>
                    <select name="approver"  title="choose Approver" class="form-control" id='sel2' required>
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
                    <span class="input-group-addon">Terms</span>
                    <textarea class="form-control" rows="4" id="comment" placeholder="State terms and conditions that were agreed upon" name="terms" required></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary le-btn" name="update_contract">UPDATE CONTRACT <i class="fa fa-send"></i></button>
              </div>
            </form>
            <div class="col-md-12">
              <h2>Current Contracts</h2>
              <div class="table-responsive">                
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Work ID</th>
                      <th>Job Name</th>
                      <th>Start Date</th>
                      <th>Stop Date</th>
                      <th>Approved By</th>
                      <th>Status</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM contract_tb ORDER BY contract_id DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['contract_id']; ?></td>
                      <td><?php echo $row['c_work_id']; ?></td>
                      <td><?php echo $row['job_name']; ?></td>
                      <td><?php echo $row['start_date']; ?></td>
                      <td><?php echo $row['stop_date']; ?></td>
                      <td><?php echo $row['approver']; ?></td>
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