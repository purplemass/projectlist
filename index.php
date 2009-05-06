<?php

# TESTSTSTSTSST

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
## ALTER TABLE IN sqlite is like so
################################################################

$s = <<<EOF
BEGIN TRANSACTION;
CREATE TEMPORARY TABLE list_backup(id, name, notes, date, person);
INSERT INTO list_backup SELECT id, name, notes, date, person FROM list;
DROP TABLE list;
CREATE TABLE list(id, name, notes, enddate, person);
INSERT INTO list SELECT id, name, notes, date, person FROM list_backup;
DROP TABLE list_backup;
COMMIT;
EOF;

#dbExec($s);
		
################################################################
## variables
################################################################

$thisScript	= $_SERVER['PHP_SELF'];

$title		= 'DC-Technology Project List';

$hiddenType	= 'hidden';

$msg		= '';

$BL['number']	= array("width"=>15, 	"size"=>3,	"maxchar"=>3);
$BL['name']		= array("width"=>220,	"size"=>34,	"maxchar"=>34);
$BL['notes']	= array("width"=>350,	"size"=>255,	"maxchar"=>255);
$BL['enddate']	= array("width"=>70,	"size"=>10,	"maxchar"=>10);
$BL['person']	= array("width"=>100,	"size"=>14,	"maxchar"=>14);
$BL['buttons']	= array("width"=>165,	"size"=>1,	"maxchar"=>1);

$BL['client']	= array("width"=>130,	"size"=>1,	"maxchar"=>15);
$BL['jobnum']	= array("width"=>50,	"size"=>1,	"maxchar"=>15);

################################################################
## form variables
################################################################

$flag	= getVar('flag', 0);
$idnum	= getVar('idnum', 0);

if ($flag == 'save') {

	$name		= getVar('name');
	$notes		= getVar('notes');
	$enddate	= getVar('enddate');
	$person		= getVar('person');
	
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

		//nothing here
		break;
		
	case 'cancel':

		//nothing here
		break;

	case 'save':
		
		if ($idnum == -1) {
			addRecord($name, $notes, $enddate, $person);
		} else {
			saveRecord($idnum, $name, $notes, $enddate, $person);
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

	#$s = "<div class=\"buttons\"><a href=\"#\" onClick=\"$js\">$label</a><span></span></div>";
	$s = "<div class=\"buttons\"><a href=\"JavaScript:$js\">$label</a><span></span></div>";
	
	return $s;

}

################################################################
## addInput
################################################################

function addInput($label, $entry) {

	global $BL;
	
	$s = '<input name="' . $label .
		'" id="' . $label .
		'" value="' . $entry[$label] .
		'" size="' . $BL[$label]['size'] .
		'" maxlength="' . $BL[$label]['maxchar'] .
		'" type="text">';
		
	return $s;
}

################################################################
## addDiv
################################################################

function addDiv($class, $width, $value, $closeTag=1) {

	
	if ($closeTag) $closeTag='</div>';
	else $closeTag = '';
	
	return "      <div class=\"$class\" style=\"width: " . $width . "px\">$value$closeTag\n";
	
}

################################################################
## rowHTML
################################################################

function rowHTML($number, $entry, $forceEdit, $showButtons) {

	global $flag;
	global $hiddenType;
	
	global $BL;
	
	$div		= '';
	
	$id 		= $entry['id'];
	$name 		= $entry['name'];
	$notes		= $entry['notes'];
	$enddate	= $entry['enddate'];
	$person		= $entry['person'];
	
	$button1	= addButton('Edit', "editRecord($id)");
	$button2	= addButton('Delete', "deleteRecord($id)");
	
	if ($forceEdit) {

		$number		= "&nbsp";
		$name 		= addInput('name', $entry);
		$notes		= '<textarea name="notes" id="notes">' . $notes . '</textarea>';
		$enddate	= addInput('enddate', $entry);
		$person		= addInput('person', $entry);
		$button1	= addButton('Save', "saveRecord($id)");
		$button2	= addButton('Cancel', "cancelRecord($id)");

	}
	
	if ($showButtons == 0) {
		$button1 = '&nbsp;';
		$button2 = '&nbsp;';
	}
	
	$div	.= addDiv('tableDiv numberDiv', $BL['number']['width'], $number);
	
	$div	.= addDiv('tableDiv', $BL['name']['width'], '', 0);
	
	$div	.= addDiv('clientDiv', $BL['client']['width'], 'Ford');
	$div	.= addDiv('jobDiv', $BL['jobnum']['width'], '1999/M');
	$div	.= addDiv('nameDiv', $BL['name']['width'], $name); #<p onClick=\"//editValue(this)\">$name</p></div>
	
	$div	.= "      </div>\n";
	
	$div	.= addDiv('tableDiv notesDiv', $BL['notes']['width'], $notes);
	$div	.= addDiv('tableDiv enddateDiv', $BL['enddate']['width'], $enddate);
	$div	.= addDiv('tableDiv personDiv', $BL['person']['width'], $person);
	$div	.= addDiv('tableDiv buttonsDiv', $BL['buttons']['width'], $button1 . $button2);
	
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
	#$table .= rowHTML(0, 0, -1, '#', 'NAME', 'NOTES', 'END DATE', 'ASSIGNED TO');
	
	$ra	= getRecords();
	$number = 0;
	
	if ($flag == 'add') {
		$flag == 'edit';
		$table .= rowHTML(-1, 1, 1, 1);
	}
		
	foreach ($ra as $entry) {
	
		$number++;
		
		$id		= $entry['id'];
	
		$forceEdit	= 0;
		$showButtons	= 0;
		
		if ($loggedin == 1) $showButtons = 1;
		
		if ( ($flag == 'edit') && ($id == $idnum) ) $forceEdit = 1;
		if ( ($flag == 'edit') && ($id != $idnum) ) $showButtons = 0;
		if ( ($flag == 'add')  ) $showButtons = 0;
		
		$table .= rowHTML($number, $entry, $forceEdit, $showButtons);
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