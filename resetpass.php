<?php

require __DIR__ . '/database.php';
$conn = db();

require __DIR__ . '/lib/phpmailer/mail.php';

if(isset($_POST['commit'])){
  //validate email
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$query = $conn->prepare('SELECT email FROM staff_tb WHERE email = :email');
		$query->execute(array(':email' => $_POST['email']));
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is NOT recognised.';
		}

	}
  if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

		try {

			$query = $conn->prepare("UPDATE staffdb SET resetToken = :token WHERE email = :email");
			$query->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
			$subject = "LOMS Password Reset";
			$body = "<p>Someone requested that the password be reset.</p>
			<p>If this was a mistake, just ignore this email and nothing will happen.</p>
			<p>To reset your password, visit the following address: <a href='".DIR."reset.php?key=$token'>".DIR."reset.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			header('Location: index.php?action=reset');
			exit;

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
    <title>Password Reset</title>
    <link rel="stylesheet" type="text/css" href="css/resetpass.css">
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>
  <body>
    <div class="login">
    <h1>Reset Your Password</h1>
    <form method="post" action="">
      <p class="pass-p">Please enter your or email address. You will<br> receive a link to create a new password via <br>email.</p>
      <p><input type="email" name="email" value="" placeholder="Enter Your Work Email"></p>
      <p class="submit"><input type="submit" name="commit" value="SUBMIT EMAIL"></p>
      <p class="submit"><input type="submit" name="back"  value="BACK TO LOGIN"></p>
       
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