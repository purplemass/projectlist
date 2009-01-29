<?php

################################################################

# login.php
# login to task list for DC-Technology
# bhat/imagination/29.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/29.01.2009: version 1.0

################################################################
## init
################################################################

session_start();

include_once('include/common.php');
include_once('include/db.php');

################################################################
## form variables
################################################################

$username = getVar('username');
$password = getVar('password');

################################################################
## variables
################################################################

$logit	= 0;

################################################################
## process
################################################################

$r	= getUserDetails($username);
$pw	= $r[0]['password'];

if (count($r) > 0) {
	if ($pw == $password) {
		$logit = 1;
		
		$_SESSION['loggedin'] = $logit;
		$_SESSION['time'] = mktime();
		$_SESSION['user'] = $username;
		
	} else {
	
		$_SESSION = array();
		
	}
}

header("location:index.php");

################################################################

#end


?>