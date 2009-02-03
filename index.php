<?php

################################################################

# list.php
# ammend weekly task list for DC-Technology
# bhat/imagination/16.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/16.01.2009: version 1.0

################################################################
## init
################################################################

include_once('include/common.php');
include_once('include/db.php');

################################################################
## variables
################################################################

$thisScript	= $_SERVER['PHP_SELF'];

$title		= 'DC-Technology Project List';

$hiddenType	= 'hidden';

$msg		= ''; //"FLAG: $flag IDNUM: $idnum";

$w1		= 15;
$w2		= 200;
$w3		= 350;
$w4		= 90;
$w5		= 90;
$w6		= 165;
$w7		= 130;
$w8		= 50;
$w_t	= $w1+$w2+$w3+$w4+$w5+$w6+$w7;

################################################################
## form variables
################################################################

$flag	= getVar('flag', 0);
$idnum	= getVar('idnum', 0);

if ($flag == 'save') {

	$name	= getVar('name');
	$notes	= getVar('notes');
	$date	= getVar('delivery_date');
	$person	= getVar('person');
	
}

################################################################
## sessions
################################################################

$session_timer = 60*5; # seconds!!!

session_cache_limiter('private');
session_cache_expire (180);
session_start();

$loggedin = isset($_SESSION['loggedin']);

if(empty($_SESSION['loggedin']) || !isset($_SESSION['time'])) {

	destroySession();

} elseif ( (isset($_SESSION['time']) && ( (mktime() - $_SESSION['time']) > $session_timer) )) { 

	destroySession();
	$msg = "Logged out";

} else {

	$_SESSION['time'] = mktime();

}

################################################################
## process
################################################################

$r = createDB();
if ($r) $msg = $r;

switch ($flag) {

	case 'logout':
		session_destroy();
		$_SESSION = null;
		$loggedin = 0;
		break;

	case 'delete':

		deleteRecord($idnum);
		break;

	case 'edit':

		//nothin here
		break;
		
	case 'cancel':

		//nothin here
		break;

	case 'save':
		
		if ($idnum == -1) {
			addRecord();
		} else {
			saveRecord($idnum);
		}
		break;
		
	case 'add':
	
		//nothing here
		break;

}

################################################################
## HTML
################################################################

$table = BuildTable();

if ($msg == '') {
	#$msg = "SESSION: " . $_SESSION['loggedin']; 
	#. ">>>>" . (mktime() - $_SESSION['time']);
}

include('include/html.php');

echo $html;

################################################################
## p
################################################################

function p ($s) {

	if ($s == '') {
		echo 'Nothing to print!';
	} else {
		echo $s . '<br />';
	}
}

################################################################
## addButton
################################################################

function addButton($label, $js) {

	$s = "<div class=\"buttons\"><a href=\"#\" onClick=\"$js\">$label</a><span></span></div>";
	$s = "<div class=\"buttons\"><a href=\"JavaScript:$js\">$label</a><span></span></div>";
	
	return $s;

}

################################################################
## rowHTML
################################################################

function rowHTML($forceEdit, $showButtons, $id, $number, $name, $notes, $date, $person) {

	global $flag;
	global $hiddenType;
	global $chars_number, $chars_name, $chars_notes, $chars_date, $chars_person;
		
	global $w1, $w2, $w3, $w4, $w5, $w6, $w7, $w8, $w_t;
	
	$div		= '';
	
	$button1	= addButton('Edit', "editRecord($id)");
	$button2	= addButton('Delete', "deleteRecord($id)");
	
	if ($forceEdit) {

		$number		= "&nbsp";
		$name 		= "<input name=\"name\"  id=\"name\" value=\"$name\"
						size=\"25\" maxlength=\"$chars_name\" type=\"text\">";
		$notes		= "<textarea name=\"notes\"  id=\"notes\">$notes</textarea>";
		$date		= "<input name=\"delivery_date\"  id=\"delivery_date\" value=\"$date\"
						size=\"12\" maxlength=\"$chars_date\" type=\"text\">";
		$person		= "<input name=\"person\"  id=\"person\" value=\"$person\"
						size=\"10\" maxlength=\"$chars_person\" type=\"text\">";

		$button1	= addButton('Save', "saveRecord($id)");
		$button2	= addButton('Cancel', "cancelRecord($id)");
	

	}
	
	if ($showButtons == 0) {
		$button1 = '&nbsp;';
		$button2 = '&nbsp;';
	}

	/*
	$div	.= "    <tr>\n";
	$div	.= "      <td width=\"$w1\">$number</td>\n";
	$div	.= "      <td width=\"$w2\"><p onClick=\"editValue(this)\">$name</p></td>\n";
	$div	.= "      <td width=\"$w3\" valign=\"top\"><p>$notes</p></td>\n";
	$div	.= "      <td width=\"$w4\">$date</td>\n";
	$div	.= "      <td width=\"$w5\">$person</td>\n";
	$div	.= "      <td width=\"$w6\">&nbsp;</td>\n";
	$div	.= "      <td width=\"$w7\">$button1 $button2<div class=\"msgDiv\" id=\"msgDiv$id\"></div></td>\n";
	$div	.= "    </tr>\n";
	*/
	
	$div	.= "      <div class=\"tableDiv numberDiv\"  style=\"width: " . $w1 . "px\">$number</div>\n";
	
	$div	.= "      <div class=\"tableDiv\"    style=\"width: " . $w2 . "px\">\n";
	
	$div	.= "      <div class=\"clientDiv\"  style=\"width: " . $w7 . "px\">CLIENT</div>\n";
	$div	.= "      <div class=\"jobDiv\"     style=\"width: " . $w8 . "px\">JOB NO</div>\n";
	$div	.= "      <div class=\"nameDiv\"    style=\"width: " . $w2 . "px\"><p onClick=\"editValue(this)\">$name</p></div>\n";
	
	$div	.= "      </div>\n";
	
	$div	.= "      <div class=\"tableDiv notesDiv\"   style=\"width: " . $w3 . "px\"><p>$notes</p></div>\n";
	$div	.= "      <div class=\"tableDiv dateDiv\"    style=\"width: " . $w4 . "px\">$date</div>\n";
	$div	.= "      <div class=\"tableDiv personDiv\"  style=\"width: " . $w5 . "px\">$person</div>\n";
	$div	.= "      <div class=\"tableDiv buttonsDiv\" style=\"width: " . $w6 . "px\">$button1$button2</div>\n";
	
	$div	.= "      <div class=\"msgDiv\" id=\"msgDiv$id\"></div>\n";
	
	$div	.= "      <div class=\"clearboth\"></div>\n\n";
	
	return $div;
}

################################################################
## BuildTable
################################################################

function BuildTable() {

	global $flag, $idnum, $loggedin;
	
	$table	= '';
	$ra	= getRecords();
	$number = 0;
	
	if ($flag == 'add') {
		$flag == 'edit';
		$table .= rowHTML(1, 1, -1, '', '', '', '', '');
	}
	
	foreach ($ra as $entry) {
	
		$number++;
		$id	= $entry['id'];
		$name	= $entry['name'];
		$notes	= $entry['notes'];
		$date	= $entry['date'];
		$person	= $entry['person'];
	
		$forceEdit = 0;
		$showButtons = 0;
		
		if ($loggedin == 1) $showButtons = 1;
		
		if ( ($flag == 'edit') && ($id == $idnum) ) $forceEdit = 1;
		if ( ($flag == 'edit') && ($id != $idnum) ) $showButtons = 0;
		if ( ($flag == 'add')  ) $showButtons = 0;
		
		$table .= rowHTML($forceEdit, $showButtons, $id, $number, $name, $notes, $date, $person);
	}
	
	return $table;
}

################################################################
## destroySession
################################################################

function destroySession() {

	global $flag, $loggedin;
	
	#unset($_SESSION['loggedin']);
	#unset($_SESSION['time']);
	
	session_destroy();
	$_SESSION = null;
	$loggedin = 0;
	$flag = '';
	
}

################################################################

#end


?>