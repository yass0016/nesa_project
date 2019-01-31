<?php
	include('init.php');

	if (!empty($_SESSION['profid'])) {
		header('Location: index.php');
	}

	/* error array containing all the error messages */
	$errors = array();

	if (isset($_POST['username'], $_POST['password'])) {
	
		// check for professor entered username
		if (empty($_POST['username'])) {
			$errors[] = 'You must enter a username.';
		}
		
		// check for professor entered password
		if (empty($_POST['password'])) {
			$errors[] = 'You must enter a password';
		}
		
		// check for valid username or password
		if (check_login($_POST['username'], $_POST['password']) === false) {
			$errors[] = 'You entered invalid username or password';
		}
		
		// if array is empty then no errors have been detected then login
		if (empty($errors)) {
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
<title>Professor Login</title>
</head>
<body>
<?php include('header.php'); ?>
    <div id="leftbar" class="sidebar">
      <div class="title">
        <h3>Information</h3>
      </div>
      <div class="back">
        <ul>
          <li>To manage terms and students and their grades you must login first</li>
        </ul>
      </div>
      <div class="bottom"></div>
    </div>
<div id="content">
<div class="post">
      <h2>Professor Login</h2>
      <p>
        <?php
						// check if error is not empty then print all detected errors
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
						} else {
							echo "New Professor? <a href='register.php'>Register Here</a>";
						}
					?>
      </p>
</div>
<div class="formWrapper">
  <div class="formHeader">
      <h3>Login</h3>
  </div>
    <form class="form" action="" method="post">
	    <fieldset>
        <label class="label"  for="username">Username:</label>
        <input type="text" class="required" autocorrect="off" autocapitalize="off" name="username" id="username" />
      <br/>
      <div class="clear">&nbsp;</div>
        <label class="label" for="password">Password:</label>
        <input type="password" class="required" autocorrect="off" autocapitalize="off" name="password" id="password" />
      <br/>
      <div class="clear">&nbsp;</div>
        <input type="submit" value="Login" class="btn primary wide" />
    </fieldset>
    </form>
	</div>
  </div>
 <?php include('footer.php'); ?>
</body>
</html>