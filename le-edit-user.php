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
        <title>View Staff Info</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!-- Style -->
      <style>
        .bg{background-color: #f1f1f1;}
        .fn {display:none;}
        .bal-tab{width: 27%}
        .nav-details{display: }
      </style>
    </head>
    <body>
      <?php require ('le-nav-admin.php'); ?>
      <div class="container">
        <div class="row">
          <?php
				if(isset($error)){
					foreach($error as $error){
						echo '<div class="alert alert-danger" id="error"><strong>Error: </strong>'.$error.'<a href="javascript:void(0)" onclick="side_close()" class="error_closebtn">&times;</a><br> </div>';
					}
				}
          ?>
          <div class="add-tab left card-4">
            <h1><i class="fa fa-edit"></i> VIEW USER'S 
              <span class="label label-primary">
                All = <?php
                $stmt = $conn->prepare("SELECT * FROM staff_tb");
                $stmt->execute();
                echo $stmt->rowCount();
                ?></span></h1>
            <div class="col-md-12">
              <div class="table-responsive">                
                <table class="table table-striped table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Dob</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Nation Id</th>
                      <th>Work Id</th>
                      <th>Role</th>
                      <th>Department</th>
                      <th>Status</th>
                      <th>Level</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                    $result = $conn->prepare("SELECT * FROM staff_tb ORDER BY staffid DESC");
                    $result->execute();
                    for($i=0; $row = $result->fetch(); $i++){ ?>
                    <tr>
                      <td><?php echo $row['staffid']; ?></td>
                      <td><?php echo $row['fname']; ?></td>
                      <td><?php echo $row['dob']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['phone']; ?></td>
                      <td><?php echo $row['national_id']; ?></td>
                      <td><?php echo $row['work_id']; ?></td>
                      <td><?php echo $row['role']; ?></td>
                      <td><?php echo $row['department']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                      <td><?php echo $row['level']; ?></td>
                      <td><button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $row['staffid']; ?>" id="getUser" class="btn btn-sm btn-info" title="View"><i class="glyphicon glyphicon-eye-open"></i></button></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
                            	<i class="glyphicon glyphicon-user"></i> Edit User Profile
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                       	   <div id="modal-loader" style="display: none; text-align: center;">
                       	   	<img src="ajax-loader.gif">
                       	   </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content"></div>
                             
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div><!-- /.modal --> 
      </div>
<?php require('footer.php'); ?>
