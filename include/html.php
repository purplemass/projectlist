<?php

################################################################

# html.php
# ammend weekly task list for DC-Technology
# bhat/imagination/18.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/16.01.2009: version 1.0

################################################################
## variables
################################################################

$msgDiv = "<div id=\"msgDiv\">$msg&nbsp;</div>";
if ($msg == '') $msgDiv = '';

$topButton1	= '&nbsp;';
$topButton2	= '&nbsp;';

$focusName	= 0;

################################################################
## LOGIN FORM
################################################################


if ($loggedin) {

	$focusName	= 1;
	if ( ($flag != 'edit') && ($flag != 'add')) {
		$topButton2	= addButton('Add Project', 'addRecord()');
		$focusName	= 0;
	}
	
	$username = $_SESSION['user'];
	
	$mybutton = addButton('Logout', 'logOut()');
	
	$loginForm = <<<EOF
<div style="float: left">You are logged in as <strong>$username</strong>.</div>$mybutton
EOF;

} else {

	$mybutton = addButton('Login', 'logIn()');
	
	$loginForm = <<<EOF
<div style="float: left">
<form method="POST" action="login.php" name="loginform" id="loginform">
<p>
  <label for="username">Username:</label> <input type="text" name="username" id="username" size="5" maxlength=\"10\" />
  <label for="password">Password:</label> <input type="password" name="password" id="password" size="5" maxlength=\"10\" />
</p>
</form>
</div>
$mybutton
EOF;
}

################################################################
## HTML
################################################################

$html = <<<EOF

<?xml version="1.0" encoding="ISO-8859-1" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1 DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-quiv="pragma" content="no-cache">

<title>$title</title>

<script src="assets/jquery.js" type="text/javascript" /></script>
<script src="assets/script.js" type="text/javascript" /></script>

<link rel="stylesheet" type="text/css" href="assets/styles.css" />

</head>
<body onLoad="showEdit($focusName)">
<div id="pageTitle">
<h1>$title</h1>
<h2>$displayDate $displayTime</h2>
</div>
<div id="logIn">$loginForm</div>
<div id="pageBody">
<form method="POST" action="$thisScript" name="mainform" id="mainform">
<input type="$hiddenType" name="flag" value="$flag">
<input type="$hiddenType" name="idnum" value="$idnum">
<input type="$hiddenType" name="loggedin" value="$loggedin">
<div style="float: left">$topButton2</div>
<div class="clearboth"></div>
<!--
<table width="$w_t" cellspacing="0">
  <tr>
    <td width="$w1" class="tableTitle">#</td>
    <td width="$w2" class="tableTitle">Name</td>
    <td width="$w3" class="tableTitle">Notes</td>
    <td width="$w4" class="tableTitle">Delivery&nbsp;date</td>
    <td width="$w5" class="tableTitle">Assigned&nbsp;to</td>
    <td width="$w6" class="tableTitle">$topButton1</td>
    <td width="$w7" class="tableTitle">$topButton2</td>
  </tr>
</table>
//-->
$table
</form>
</div>
<div id="msgDiv" class="msgDiv">$msg</div>
</body>
</html>

EOF;

################################################################

#end

?>