<?php

################################################################

# common.php
# common functions for weekly task list for DC-Technology
# bhat/imagination/29.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/29.01.2009: version 1.0

################################################################
## init
################################################################

ini_set("display_errors", 1);
error_reporting(E_ALL);

################################################################
## common variables
################################################################

$displayDate	= strftime("%d-%m-%Y");
$displayTime	= strftime("%H:%M:%S");

$R		= '<br />';

################################################################
## getVar
################################################################

function getVar($s, $check=1) {

	global $msg, $flag, $idnum;
	
	if (empty($_REQUEST[$s])) return '';
	
	$r = strip_tags(htmlentities($_REQUEST[$s]));
	
	if ( !$r && $check ) {
		$msg .= "You must fill in all the values - '$s' is missing<br />";
		$flag	= 'edit';
		return '';
	} else {
		return $r;
	}
}

################################################################

#end


?>