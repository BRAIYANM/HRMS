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

/*$dt1 = $_POST['date'];
$dt2 = $_POST['date2'];
$dtdiff = date_diff($date1,$date2);
$days_avail = $_POST['days_avail'];*/

if(isset($_POST['submit'])){
  if(strlen($_POST['workid']) < 5){
		$error[] = 'Work ID is too short.';
	} else {
		$query = $conn->prepare('SELECT workid FROM staffdb WHERE workid = :workid');
		$query->execute(array(':workid' => $_POST['workid']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['workid'])){
			$error[] = 'Work ID provided is NOT in use.';
		}
	}
    if(!isset($error)){
		try {
          $conn = db();
			$query = $conn->prepare('INSERT INTO extratb (workid,start,stop,days_avail) VALUES (:workid, :start, :stop, :days_avail)');
			$query->execute(array(
				':workid' => $_POST['workid'],
				':start' => $_POST['date'],
                ':stop' => $_POST['date2'],
				':days_avail' => $_POST['days_avail']
			));
          
          header('Location: le-extra-hours.php?action=extra hours submited');
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
        <title>Fill extra hours</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
      <style>
        .side-details {
          overflow:hidden;
          position:absolute !important;
          display:none;
        }
        @media only screen and (min-width :1100px) {
          #sidemenu {width:200px;display:block;}
        }
      </style>
    </head>
    <body>
        <div id="nav-bar">
        <ul class="nav-details card-2">
          <li class="web-name scroll"><a href="le-user.php">HRMS</a></li>
          <!--<div class="sidecheck">
          <a id="menubtn" href='javascript:void(0);' class='sid' onclick='w3_open()' title='Menu'>&#9776;</a>
          </div>-->
          <!--<li class="scroll"><a href="le-user.php"title="My Account"><img src="images/user_img.png" class="img_circle" style="height:25px;width:25px" alt="Avatar"><?php #echo $user->name;?></a></li>-->
          <li class="scroll"><a href="le-status.php">Leave Status</a></li>
          <li class="scroll active"><a href="#">Extra-Hrs</a></li>
          <li class="scroll"><a href="le-apply.php">Apply Leave</a></li>
          <li class="scroll"><a href="le-dayoff.php">Apply Off</a></li>
          <!--<li class="scroll"><a href="test.php">test</a></li>-->
          <li class="drop" onclick="myFunction()"><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">drop</a>
            <div id="myDropdown" class="dropdown-content"><a href="reset.php">Profile</a><a href="">LogOut</a></div></div></li>
          <li class="scroll"><a href="logout.php">Log Out</a></li>
        </ul>
      </div>
      <script>
        /*$(document).ready(function(){
          $(".dropdown").on
          ("hide.bs.dropdown", function(){
            $(".btn").html('Dropdown<span class="caret"></span>');
          });
          $(".dropdown").on
          ("show.bs.dropdown", function(){
            $(".btn").html('Dropdown<span class="caret caret-up"></span>');
          });
        });
        function myFunction(){
          document.getElementById
          ("myDropdown").classList.toggle
          ("show");
        }*/
        window.onclick = function(event){
          if(!event.target.matches('.drop'))
            {
              var dropdowns = document.getElementsByClassName
              ("dropdown-content");
              var i;
              for(i=0; i<dropdowns.length; i++)
                {
                  var openDropdown = dropdowns[i];
                  if
                    (openDropdown.classList.contains
                    ('show')){
                      openDropdown.classList.remove
                      ('show');
                    }
                }
            }
        }
        function w3_open() {
          if (w3_getStyleValue(document.getElementById("sidemenu"), "display") == "block") {
            w3_close();
            return;
          }
          /*document.getElementById("main").style.marginLeft = "230px";*/
          document.getElementById("sidemenu").style.width = "200px";
          document.getElementById("main").style.transition = ".4s";
          document.getElementById("sidemenu").style.display = "block";
        }
        function w3_getStyleValue(elmnt,style) {
          if (window.getComputedStyle) {
            return window.getComputedStyle(elmnt,null).getPropertyValue(style);
          } else {
            return elmnt.currentStyle[style];
          }
        }
        function w3_close() {
          /*document.getElementById("main").style.marginLeft = "0%";*/
          document.getElementById("sidemenu").style.display = "none";
        }
      </script>
      <!--<div class="dropdown"> <button class="drop" onclick="myFunction()">drop</button>
          <div id="myDropdown" class="dropdown-content"><a href="#">link 1</a><a href="#">link 2</a></div></div>
      <div id="mydropdown" class="dropdown-content">
        <a href="#">link 1</a>
        <a href="#">link 2</a>
      </div>-->
      <?php #require('sidenav.php'); ?>
      <div class="well extra card-2" id="main">
        <div class="form-head">
          <p class="p2">Add extra hours</p>
        </div>
        <form class="form-1" method="post" action="" >
          <table id="mytable">
            <tr>
              <td>Work ID:</td>
              <td>&nbsp;</td>
              <td><input type="text" name="workid" required></td>
            </tr>
            <tr>
              <td>Start Day:</td>
              <td>&nbsp;</td>
              <td><input type="datetime-local" name="date"/></td>
            </tr>
            <tr>
              <td>Stop Day:</td>
              <td>&nbsp;</td>
              <td><input type="datetime-local" name="date2"/></td>
            </tr>
            <tr>
              <td>Available Days:</td>
              <td>&nbsp;</td>
              <td><input type="number" name="days_avail" value="<?php echo $days_avail; ?>" required></td>
            </tr>
            <tr>
              <td><input type="submit" name="submit" value="Submit Extra Days"/></td>
            </tr>
          </table>
          <?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
          ?>
        </form>
      </div><br><br><br><br><br><br><br><br>
<?php
require('footer.php');
?>