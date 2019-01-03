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
        <title>My Profile</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    </head>
    <body><?php require ('le-nav-staff.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <form method="post">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                <li><a href="#personal" data-toggle="tab">Personal</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade in active" id="general">         
                    <div class="col-md-6">
                      <div class="form-group float-label-control">                      
                          <label for="">First Name</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->fname;?>" name="user_firstname" value="<?php echo $user->fname;?>">
                      </div>
                      <div class="form-group float-label-control">  
                          <label for="">Middle Name</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->mname;?>" name="user_lastname" value="<?php echo $user->mname;?>">
                      </div>
                      <div class="form-group float-label-control">  
                          <label for="">Last Name</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->lname; ?>" name="user_lastname" value="<?php echo $user->lname;?>">
                      </div>
                      <div class="form-group float-label-control">  
                          <label for="">Phone</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->phone; ?>" name="user_lastname" value="<?php echo $user->phone;?>">
                      </div>
                      <div class="form-group float-label-control">  
                          <label for="">Address</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->address; ?>" name="user_lastname" value="<?php echo $user->address;?>">
                      </div>
                    </div>
                  <div class="col-md-6">
                      <label for="">Username</label>
                      <div class="form-group float-label-control">   
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <fieldset disabled> 
                                <input type="text" class="form-control" placeholder="" name="user_username" value="<?php echo $user->username;?>" id="disabledTextInput" autocomplete="off">
                            </fieldset>  
                        </div>
                      </div>
                      <div class="form-group float-label-control">
                          <label for="">Password</label>
                          <input type="password" class="form-control" placeholder="******" name="user_password" value="<?php echo $user->password?>">
                      </div>
                      <div class="form-group float-label-control">
                        <label for="">Email</label> 
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <fieldset disabled>
                            <input type="text" class="form-control" placeholder="<?php echo $user->email;?>" name="user_email" value="<?php echo $user->email; ?>" id="disabledTextInput" autocomplete="off">
                          </fieldset>
                        </div>
                      </div>
                      <div class="form-group float-label-control">
                        <label for="">Work ID</label> 
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa "></i></span>
                          <fieldset disabled>
                            <input type="text" class="form-control" placeholder="<?php echo $user->work_id;?>" name="user_email" value="<?php echo $user->work_id; ?>" id="disabledTextInput" autocomplete="off">
                          </fieldset>
                        </div>
                      </div>
                      <div class="form-group float-label-control">
                        <label for="">Department</label> 
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa "></i></span>
                          <fieldset disabled>
                            <input type="text" class="form-control" placeholder="<?php echo $user->department;?>" name="user_email" value="<?php echo $user->department; ?>" id="disabledTextInput" autocomplete="off">
                          </fieldset>
                        </div>
                      </div>
                  </div>
              </div>
                <div class="tab-pane fade" id="personal">
                  <div class="col-md-6">
                      <div class="form-group float-label-control">
                          <label for="">Birthday</label>   
                          <input type="date" class="form-control" placeholder="" name="user_dob" value="<?php echo $user->dob;?>">      
                      </div>
                      <div class="form-group float-label-control">
                          <label for="">Role</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->role;?>" name="user_profession" value="<?php echo $user->role;?>" id="profession">    
                      </div>  
                  </div>
                  <div class="col-md-6">
                      <div class="form-group float-label-control">
                          <label for="">County</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->county;?>" name="user_country" value="<?php echo $user->county;?>" id="country">    
                      </div>
                      <div class="form-group float-label-control">
                          <label for="">Address</label>
                          <input type="text" class="form-control" placeholder="<?php echo $user->address;?>" name="user_address" value="<?php echo $user->address;?>">    
                      </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
<?php require('footer.php');?>