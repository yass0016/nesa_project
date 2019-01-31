<?php

/* functions for the professor account */

// check if professor already exists in the database
function prof_exists($username) {
	// protect username variable from SQL injection
	$username = mysql_real_escape_string($username);
	
	// check if there is already prof in the table with that username
	$query = "SELECT COUNT('t_id') FROM professor WHERE UserName = '{$username}'";
	$count = mysql_query($query);
	
	$result_count = mysql_result($count, 0);
	
	// return the result, if 1 then already exist return true otherwise return false
	if ($result_count > 0)
		return true;
	else
		return false;
}

// check professor entered valid login information
function check_login($username, $password) {
	// protect username variable from SQL injection
	$username = mysql_real_escape_string($username);
	
	// protect the password with a hash code
	$password = sha1($password);
	
	// check if the login information is correct
	$check_query = "SELECT COUNT('t_id') FROM professor WHERE UserName = '{$username}' AND Password = '{$password}'";
	$check_count = mysql_query($check_query);

	$result_count = mysql_result($check_count, 0);
	
	// return the result, if 1 then already exist return true otherwise return false
	if ($result_count > 0)
		return true;
	else
		return false;
}

// add a new professor to the database
function add_prof($firstname, $lastname, $email, $username, $password) {

	// protect firstname variable from SQL injection
	$firstname = mysql_real_escape_string($firstname);

	// protect lastname variable from SQL injection
	$lastname = mysql_real_escape_string($lastname);

	// protect email variable from SQL injection
	$email = mysql_real_escape_string($email);
	
	// protect username variable from SQL injection
	$username = mysql_real_escape_string($username);

	// protect the password with a hash code
	$password = sha1($password);
	
	// create insert query for the professor
	$insert_query = "INSERT INTO professor (FirstName, LastName, UserName, EmailAddress, Password, default_term) VALUES('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', -1)";
	
	// insert it to the table
	$result = mysql_query($insert_query);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}

}

function student_exist($studentnum)
{
	// protect studentnum variable from SQL injection
	$studentnum = mysql_real_escape_string($studentnum);
	
	// check if there is already prof in the table with that username
	$query = "SELECT COUNT('s_id') FROM student WHERE s_number = '{$studentnum}'";
	$count = mysql_query($query);
	
	$result_count = mysql_result($count, 0);
	
	// return the result, if 1 then already exist return true otherwise return false
	if ($result_count > 0)
		return true;
	else
		return false;
}

function count_students($t_id, $term_id) {
	// protect username variable from SQL injection
	$t_id = mysql_real_escape_string($t_id);
	$term_id = mysql_real_escape_string($term_id);
	
	// check if there is already prof in the table with that username
	$query = "SELECT COUNT('s_id') FROM student WHERE TeacherID = '{$t_id}' AND TermID = '{$term_id}'";
	$count = mysql_query($query);
	
	$result_count = mysql_result($count, 0);
	
	return $result_count;
}

?>