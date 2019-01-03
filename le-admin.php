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
if(isset($_POST['add_staff'])){
  //basic validation
  if(isset($_POST['username'])){
		$query = $conn->prepare('SELECT username FROM staff_tb WHERE username = :username');
		$query->execute(array(':username' => $_POST['username']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}
  //password verification
  if(strlen($_POST['password']) < 5){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['conf_pass']) < 5){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['conf_pass']){
		$error[] = 'Passwords do not match.';
	}
  //checking whether the worrkid is in stafftb
  if(isset($_POST['work_id'])){
		$query = $conn->prepare('SELECT work_id FROM staff_tb WHERE work_id = :work_id');
		$query->execute(array(':work_id' => $_POST['work_id']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['work_id'])){
			$error[] = 'Work ID provided is already in use.';
		}
	}
  if(strlen($_POST['work_id']) < 6){
		$error[] = 'Work ID is too short.';
	}
  //validate email
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$query = $conn->prepare('SELECT email FROM staff_tb WHERE email = :email');
		$query->execute(array(':email' => $_POST['email']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}
  //insert data into staff_tb if there's no errors
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO staff_tb (fname, lname, mname, gender, dob, marriage, email, phone, national_id, county, city, address, work_id, role, ext, qualification, department, supervisor, status, office_no, username, password, conf_pass, level) VALUES (:fname, :lname, :mname, :gender, :dob, :marriage, :email, :phone, :national_id, :county, :city, :address, :work_id, :role, :ext, :qualification, :department, :supervisor, :status, :office_no, :username, :password, :conf_pass, :level)');
			$query->execute(array(
				':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':mname' => $_POST['mname'],
                ':gender' => $_POST['gender'],
                ':dob' => $_POST['dob'],
                ':marriage' => $_POST['marriage'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':national_id' => $_POST['national_id'],
                ':county' => $_POST['county'],
                ':city' => $_POST['city'],
                ':address' => $_POST['address'],
                ':work_id' => $_POST['work_id'],
                ':role' => $_POST['role'],
                ':ext' => $_POST['ext'],
                ':qualification' => $_POST['qualification'],
                ':department' => $_POST['department'],
                ':supervisor' => $_POST['supervisor'],
                ':status' => $_POST['status'],
                ':office_no' => $_POST['office_no'],
                ':username' => $_POST['username'],
                ':password' => $_POST['password'],
                ':conf_pass' => $_POST['conf_pass'],
                ':level' => $_POST['level']
                
			));
          
          header('Location: le-admin.php?action=staff added');
		  exit;
          
          //send notification email to the new user
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
}

//add Leave Type
if(isset($_POST['add_leave'])){
  //basic validation
  if(strlen($_POST['leave_name']) < 3){
		$error[] = 'Leave Name is too short.';
	} else {
		$query = $conn->prepare('SELECT leave_name FROM def_leave WHERE leave_name = :leave_name');
		$query->execute(array(':leave_name' => $_POST['leave_name']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['leave_name'])){
			$error[] = 'Leave Name provided is already in use.';
		}

	}
  //insert data into def_leave if there's no errors
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO def_leave (leave_name,def_days) VALUES (:leave_name, :def_days)');
			$query->execute(array(
				':leave_name' => $_POST['leave_name'],
				':def_days' => $_POST['def_days']
			));
          
          header('Location: le-admin.php?action=leave added');
		  exit;
          
        }
      catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}
}
//add Off Type
if(isset($_POST['add_off'])){
  //basic validation
  if(strlen($_POST['off_name']) < 2){
		$error[] = 'Off Name is too short.';
	} else {
		$query = $conn->prepare('SELECT off_name FROM def_off WHERE off_name = :off_name');
		$query->execute(array(':off_name' => $_POST['off_name']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['off_name'])){
			$error[] = 'Off Name provided is already in use.';
		}

	}
  //insert data into def_off if there's no errors
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO def_off (off_name,def_days) VALUES (:off_name, :def_days)');
			$query->execute(array(
				':off_name' => $_POST['off_name'],
				':def_days' => $_POST['def_days']
			));
          
          header('Location: le-admin.php?action=off added');
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
        <title>Add new Users</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <style>
          .Off-tab{margin: 0 auto 26px auto;}
        </style>
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
            <form method="post" class="u-form">
              <h1><i class="fa fa-plus-square"></i> ADD A NEW USER</h1>
              <div class="col-md-6">
                <h2>Personal Information</h2>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">First Name</span>
                      <input type="text" class="form-control" placeholder="First Name" name="fname" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Middle Name</span>
                      <input type="text" class="form-control" placeholder="Middle Name" name="mname" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Last Name</span>
                      <input type="text" class="form-control" placeholder="Last Name" name="lname" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i> Gender</span>
                      <select name="gender"  title="Choose Your Gender" class="form-control" id="sel2" required>
                        <option ></option>
                        <option value='Male'>Male</option>
                        <option value='Female' >Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i> D.O.B</span>
                      <input type="date" class="form-control" name="dob" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i> Marital Status</span>
                      <select name="marriage"  title="Choose Your Status" class="form-control" id="sel2" required>
                        <option ></option>
                        <option value='Married'>Married</option>
                        <option value='Single' >Single</option>
                        <option value='Complicated' >Complicated</option>
                        <option value='Divorced' >Divorced</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i> Email</span>
                      <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-tablet"></i> Phone No.</span>
                      <input type="number" class="form-control" placeholder="Phone No." name="phone" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-id-card"></i> National ID</span>
                      <input type="number" class="form-control" placeholder="National ID" name="national_id" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i> County</span>
                      <input type="text" class="form-control" placeholder="County" name="county" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i> City</span>
                      <input type="text" class="form-control" placeholder="City" name="city" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-address-card"></i>Address</span>
                      <input type="text" class="form-control" placeholder="Address" name="address" required>
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                <h2>Work Information</h2>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-id-badge"></i> Work ID</span>
                      <input type="text" class="form-control" placeholder="Work ID" name="work_id" min="6" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Role</span>
                      <input type="text" class="form-control" placeholder="Role" name="role" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-phone"></i> Extension</span>
                      <input type="number" class="form-control" placeholder="Extension" name="ext" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-graduation-cap"></i> Qualification</span>
                      <input type="text" class="form-control" placeholder="Qualification" name="qualification" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Department</span>
                      <select name="department"  title="Choose Your Department" class="form-control" id="sel2" required>
                        <option ></option>
                        <option value='FINANCE'>Finance</option>
                        <option value='ACTURIAL' >Acturial</option>
                        <option value='IT' >Information Technology</option>
                        <option value='HR' >Human Resource</option>
                        <option value='SALES' >Sales</option>
                        <option value='MARKETING' >Marketing</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-info-circle"></i> Supervisor</span>
                      <input type="text" class="form-control" placeholder="Supervisor" name="supervisor" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-info"></i> Status</span>
                      <select name="status"  title="Choose Your Status" class="form-control" id="sel2" required>
                        <option ></option>
                        <option value='Permanent'>Permanent</option>
                        <option value='Tempolary' >Tempolary</option>
                        <option value='Intern' >Intern</option>
                        <option value='Attachee' >Attachee</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-institution"></i> Office No.</span>
                      <input type="text" class="form-control" placeholder="Office No." name="office_no" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i> Username</span>
                      <input type="text" class="form-control" placeholder="Username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i> Password</span>
                      <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i> Confirm Password</span>
                      <input type="password" class="form-control" placeholder="Confirm Password" name="conf_pass" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Level</span>
                      <select name="level"  title="Choose Your Level" class="form-control" id="sel2" required>
                        <option ></option>
                        <option value='1'>Admin</option>
                        <option value='2' >Manager</option>
                        <option value='3' >User</option>
                      </select>
                    </div>
                </div>
              </div>
              <input type="submit" name="add_staff" value="ADD NEW USER INFO" class="btn btn-primary">
            </form>
          </div>
          <div class="add-tab left card-4">
            <form method="post" class="u-form">
              <h1><i class="fa fa-plus-square"></i> ADD A NEW LEAVE TYPE | OFF TYPE</h1>
              <div class="col-md-6">
                <h2>Add Leave Type</h2>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Leave Name</span>
                      <input type="text" class="form-control" placeholder="Leave Name" name="leave_name" min="4" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Default Days</span>
                      <input type="text" class="form-control" placeholder="Def. Days" name="def_days" required>
                    </div>
                </div>
                <input type="submit" name="add_leave" value="ADD LEAVE TYPE">
              </div>
            </form>
            <form method="post" class="u-form">
              <div class="col-md-6">
                <h2>Add Off Type</h2>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Off Name</span>
                      <input type="text" class="form-control" placeholder="Off Name" name="off_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Default Days</span>
                      <input type="text" class="form-control" placeholder="Def Days" name="def_days" required>
                    </div>
                </div>
                <input type="submit" name="add_off" value="ADD OFF TYPE" >
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>