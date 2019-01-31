<?php
	include('init.php');
	
	if (!empty($_SESSION['profid'])) {
		header('Location: index.php');
	}
	
	// store error messages in this array
	$errors = array();
	
	// check for errors if user didn't input username, password and confirm password
	if (isset($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['confirm_password'])) {	
		// required fields in the registration form
		if (empty($_POST['firstname'])) {
			$errors[] = 'You must enter a first name to continue.';
		}

		if (empty($_POST['lastname'])) {
			$errors[] = 'You must enter a last name to continue.';
		}
	
		if (empty($_POST['username'])) {
			$errors[] = 'You must enter a username.';
		}
		
		if (empty($_POST['password']) || empty($_POST['confirm_password'])) {
			$errors[] = 'You must enter a password';
		}
		
		// check for password match confirm password
		if ($_POST['password'] !== $_POST['confirm_password']) {
			$errors[] = 'Confirm password does not match your entered password';
		}
		
		// check if the professor username already exists
		if (prof_exists($_POST['username'])) {
			$errors[] = 'This username is already taken, enter a new username';
		}
		
		// check there was any error and has been stored in the errors array
		if (empty($errors)) {
			// if nothing in the errors array then add the professor
			add_prof($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['username'], $_POST['password']);
			
			// store session variables
			$username = $_POST['username'];
			$result = mysql_query("SELECT * FROM professor WHERE UserName = '{$username}'");
	
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
	
			while($row = mysql_fetch_array($result))
			{
				// store session variables
				$_SESSION['profid'] = $row['t_id'];
				$_SESSION['firstname'] = $row['FirstName'];
				$_SESSION['lastname'] = $row['LastName'];
				$_SESSION['username'] = $row['UserName'];
				$_SESSION['profemail'] = $row['EmailAddress'];
				$_SESSION['defaultterm'] = $row['default_term'];
			}
			
			$t_id = $_SESSION['profid'];
			
			$sql = "INSERT INTO rawScore (test_score, fa_score, swe_score, pi_score, sos_score, a1_score, a2_score, design_score, TeacherID)
				VALUES(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, '{$t_id}')";

			$result = mysql_query($sql);
			if(!$result) {
				echo "Failed to add raw scores";
			} else {
			}

			header('Location: index.php');
			die();
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
<title>New Professor</title>
</head>
<body>
<?php include('header.php'); ?>
    <div id="leftbar" class="sidebar">
      <div class="title">
        <h3>Information</h3>
      </div>
      <div class="back">
        <ul>
          <li>You must register to be able to manage your students and their scores</li>
        </ul>
      </div>
      <div class="bottom"></div>
    </div>
<div id="content">
<div class="post">
      <h2>Professor Register</h2>
      <p>
        <?php
						if (empty($errors) === false) {
						?>
      <ul>
        <?php
									foreach ($errors as $error) {
										echo "<li>{$error}</li>";
									}
								?>
      </ul>
      <?php
						}
					?>
      </p>
</div>
<div class="formWrapper">
  <div class="formHeader">
      <h3>Register</h3>
  </div>
    <form class="form" action="" method="post">
	    <fieldset>
        <label class="label" for="firstname">First Name:</label>
        <input type="text" class="required" autocorrect="off" autocapitalize="off"  name="firstname" id="firstname" value="<?php if (isset($_POST['firstname'])) echo htmlentities($_POST['firstname']); ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="lastname">Last Name:</label>
        <input type="text" class="required" autocorrect="off" autocapitalize="off" name="lastname" id="lastname" value="<?php if (isset($_POST['lastname'])) echo htmlentities($_POST['lastname']); ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="email">Email Address:</label>
        <input type="text" class="required" autocorrect="off" autocapitalize="off" name="email" id="email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="username">Username:</label>
        <input type="text" class="required" autocorrect="off" autocapitalize="off"  name="username" id="username"  value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="password">Password:</label>
        <input type="password" class="required" autocorrect="off" autocapitalize="off"  name="password" id="password" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="confirm_password">Confirm Password:</label>
        <input type="password" class="required" autocorrect="off" autocapitalize="off"  name="confirm_password" id="confirm_password" />
      <br/>
      <div class="clear">&nbsp;</div>
        <input type="submit" value="Register" class="btn primary wide" />
		<fieldset>
    </form>
  </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>