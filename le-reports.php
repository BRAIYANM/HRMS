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
require('javascript.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reports</title>
        <link rel="stylesheet" type="text/css" href="css/le-css.css">
        <link rel="shortcut icon" href="images/favicon.ico">
      <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!--style-->
        <style>
          .Off-tab{margin: 0 auto 26px auto;}
        </style>
    </head>
    <body>
      <?php require ('le-nav-admin.php'); ?>
      <div class="container">
        <div class="row">
          <div class="add-tab left card-4">
            <form class="" role="search" method="post" autocomplete="off" action="search-results.php">
              <h1>Generate User's Report</h1>
              <div class="col-md-12">
                <div class="form-group">
                    <input type="text" class="search form-control" id="searchbox" placeholder="Search for Users" name="search-form"/><br />
                    <div id="display"></div>
                </div> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">Information to be included</span>
                    <div class="checkbox">
                      <label>General Information</label>
                    </div>
                    <div class="checkbox">
                      <label>Leave Information</label>
                    </div>
                    <div class="checkbox">
                      <label>Off Information</label>
                    </div>
                    <div class="checkbox">
                      <label>Disciplinary &amp; Comments</label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Phone</th>
                      <th>L-Days</th>
                      <th>O-days</th>
                      <th>D-Issue</th>
                      <th>D-Details</th>
                      <th>C-Issue</th>
                      <th>C-Details</th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <button class="btn btn-primary le-btn" name="print_info" onclick="window.print()"><i class="fa fa-print"></i> PRINT REPORT <i class="fa fa-print"></i></button>
          </div>
        </div>
      </div>
      <?php require('footer.php'); ?>