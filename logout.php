<?php

/* start a session */
session_start();

/* assign all variables in session as an array */
$_SESSION = array();

/* destroy all the session variables in the array*/
session_destroy();

/* return to the index page */
header('Location: index.php');

?>