<?php
	/* start a new session */
	session_start();

	$exceptions = array('register','login');

	/* extract the page name from the path */
	$page = substr(end(explode('/', $_SERVER['SCRIPT_NAME'])), 0, -4);

	if (in_array($page, $exceptions) === false) {
		if (isset($_SESSION['username']) === false) {
			header('Location: login.php');
			die();
		}
	}

	$con = mysql_connect('localhost', 'codemod_nesa', 'yA573221');
	if (!$con) {
		die('Could not connect to mysql server: ' . mysql_error());
	}
	
	$db = mysql_select_db('codemod_nesa', $con);
	if (!$db) {
		die ('Could not connect to database : ' . mysql_error());
	}
	
	include('include.php');
?>