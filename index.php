<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="html/text" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HRMS | Login</title>
        <link href="css/main.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="images/favicon.ico">
      
    </head>
    <body>
      
<?php
//session_start();

require __DIR__ . '/database.php';
$conn = db();

require __DIR__ . '/lib/library.php';
$app = new DemoLib();

function check_input($r){
	$r=trim($r);
	$r=strip_tags($r);
	$r=stripslashes($r);
	$r=htmlentities($r);
	return $r;
}
if(isset($_POST['submit'])){
  $username = check_input($_POST['username']);
  $password = check_input($_POST['password']);
  $level= check_input($_POST['who']);
  $email = check_input($_POST['username']);

$staffid = $app->Login($username, $password, $level, $email);
  
if($staffid > 0)
{  
  
$gettime = date("m/d/y H.i:s", time());
                         
$fh = fopen("logins.txt", 'a') or die("Failed to create file");
$text = <<<_END

[  $username | $password | $gettime                                 
________________________________________________________________
_END;

fwrite($fh, $text) or die("Could not write to file");

fclose($fh);
  
try{
  //$result = $conn->prepare("SELECT level FROM staff_db WHERE staffid= :staffid");
  //$result->bindParam(':level', $level);
  
  if ($level==1){
     session_start();
     $_SESSION['staffid'] = $staffid;
     ?>
      <p align="center">Login Successful</p>
        <p align="center">
          <meta content="2;le-admin-2.php" http-equiv="refresh" />
        </p>
      <?php
  }
  else if($level==2){
    session_start();
    $_SESSION['staffid'] = $staffid;
    ?>
     <p align="center">Login Successful</p>
        <p align="center">
          <meta content="2;le-manager.php" http-equiv="refresh" />
        </p> 
      <?php
  }
  else if($level==3){
    session_start();
    $_SESSION['staffid'] = $staffid;
    ?>
      <p align="center">Login Successful</p>
        <p align="center">
          <meta content="2;le-user.php" http-equiv="refresh" />
        </p>
      <?php
  }
    else
{
  ?>
      <p align="center">Invalid login details1!</p>
        <p align="center">
          <meta content="2;index.php" http-equiv="refresh" />
        </p>
      <?php
}
}
catch (PDOException $e) {
  exit($e->getMessage());
}
  
}
  else{
    ?>
      <p align="center">Invalid login details!</p>
        <p align="center">.........</p>
      <meta content="2;index.php" http-equiv="refresh" />
      <?php
      }
}      
?>


        <div id="login">
          <div id="header">
            <p class="header_content">- HRMS Login Page -</p>
            <form method="post" name="form" class="form_login" action="">
                <fieldset><!--<legend>LOG-IN HERE</legend>-->
                <div class="input">
                  <select name="who"  title="Choose Your Category" id='in' required>
                    <option >Choose your Category</option>
                  <option value='1'>Admin</option>
                  <option value='2' >Manager</option>
                  <option value='3' >User</option>
                  </select>
                  <div class="input-1">
                    <input type="text" placeholder="Enter your Username or Email" name="username" title="Enter your Username or Email" required>
                    <!--<span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
                  </div >
                  <div class="input-1">
                    <input type="password" placeholder="Enter your Password" name="password" title="Enter your Password" required>
                    <!--<span class="glyphicon glyphicon-lock form-control-feedback"></span>-->
                  </div >
                  <div class="input-2">
                    <input type="submit" value="LOGIN" name="submit" title="Click To Login">
                    <!--a href="resetpass.php"><b class="fpass" title="Change/Recovery password here">Forgot your password? Recover here <i class="fa fa-unlock"></i></b></a>-->
                  </div>
                  </div>
                </fieldset>
              
              <?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
          ?>
            </form>
        </div>
      </div>
        <div class="main-footer">
            <div class="bottom_footer">
              <p class="p">Copyright (c) Human Resource Managent System <?php echo date("Y"); ?><br>Powered by Jose Kinyua<br><i class="fa fa-phone"></i> 0726655321</p>
              
            </div>
        </div>
      <!-- js -->
      <script src="js/jquery.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/bootstrap-formhelpers.js"></script>
      <script src="js/custom.js"></script>
      <script type="text/javascript"> 
        ChangeIt();
      </script>
      
        
      
  </body>
</html>