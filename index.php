<?php 
	include('init.php'); 
	$username = $_SESSION['username'];
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
<title></title>
</head>
<body>
<?php include('header.php'); ?>
    <div id="leftbar">

    </div>
    <div id="content">
      <p>
      <div class="post"> Welcome <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?> </div>
      </p>
    </div>
    <div id="rightbar" class="sidebar">
 
    </div>
<?php include('footer.php'); ?>
</body>
</html>