<?php

require __DIR__ . '/database.php';
$conn = db();

$query = $conn->prepare('SELECT resetToken FROM staffdb WHERE resetToken = :token');
$query->bindParam(':token', $token);
//$query->execute(array(':token' => $_GET['key']));
//$query->execute();
//$row = $query->fetch(PDO::FETCH_ASSOC);

//if no token from db then kill the page
if(empty($row['resetToken'])){
	$stop = 'Invalid token provided, please use the link provided in the reset email.';
}

if(isset($_POST['commit'])){

	//basic validation
	if(strlen($_POST['pass']) < 5){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['conf-pass']) < 5){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['pass'] != $_POST['conf-pass']){
		$error[] = 'Passwords do not match.';
	}

	//if no errors have been created carry on
	if(!isset($error)){
		try {

			$query = $conn->prepare("UPDATE staffdb SET password = :password WHERE resetToken = :token");
			$query->execute(array(
				':password' => $password,
				':token' => $row['resetToken']
			));

			//redirect to index page
			header('Location: index.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}
if(isset($_POST['back'])){
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reset Account</title>
    <link rel="stylesheet" type="text/css" href="css/resetpass.css">
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>
  <body>
    <div class="login">
    <h1>Reset Your Password</h1>
    <form method="post" action="">
      <p><input type="password" name="pass" value="" placeholder="Enter New Password"></p>
      <p><input type="password" name="conf-pass" value="" placeholder="Confirm New Password"></p>
      <p class="submit"><input type="submit" name="commit" value="SUBMIT EMAIL"></p>
      <p class="submit"><input type="submit" name="back" value="BACK TO LOGIN"></p>
       
       <?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
          ?>
    </form>
    </div>
  </body>
</html>
<?php require('footer.php'); ?>