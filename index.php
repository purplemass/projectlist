<?php

################################################################

# list.php
# ammend weekly task list for DC-Technology
# bhat/imagination/16.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/16.01.2009: version 1.0

################################################################
## variables
################################################################

$thisScript	= $_SERVER['PHP_SELF'];

$displayDate	= strftime("%d-%m-%Y");
$displayTime	= strftime("%H:%M:%S");

$title		= 'DC-Technology Task List';
$msg		= '';

$R		= '<br />';

$hiddenType	= 'hidden';

$msg		= ''; //"FLAG: $flag IDNUM: $idnum";

$w1		= 10;
$w2		= 200;
$w3		= 400;
$w4		= 90;
$w5		= 80;
$w6		= 50;
$w7		= 120;
$w_t	= $w1+$w2+$w3+$w4+$w5+$w6+$w7;

################################################################
## DB
################################################################

include('include/db.php');
$msg = createDB();

################################################################
## form variables
################################################################

$flag		= getVar('flag', 0);
$idnum		= getVar('idnum', 0);
$loggedin	= getVar('loggedin', 0);

if ($flag == 'save') {

	$name	= getVar('name');
	$notes	= getVar('notes');
	$date	= getVar('delivery_date');
	$person	= getVar('person');
	
}

################################################################
## process
################################################################

switch ($flag) {

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
	if ($flag) $msg = ' '; //"Operation: $flag record [$loggedin]";
	else $msg = ' '; //'Click a button below';
}

include('include/html.php');

echo $html;

################################################################
## p
################################################################

function getVar($s, $check=1) {

	global $msg, $flag, $idnum;
	
	if (!($_REQUEST[$s])) return '';

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
## rowHTML
################################################################

function rowHTML($forceEdit, $showButtons, $id, $number, $name, $notes, $date, $person) {

	global $flag;
	global $hiddenType;
	global $chars_number, $chars_name, $chars_notes, $chars_date, $chars_person;
		
	global $w1, $w2, $w3, $w4, $w5, $w6, $w7, $w_t;
	
	$div		= '';
	
	$button1 = "<a href=\"#\" class=\"buttons\" onClick=\"editRecord($id)\">Edit</a>";
	$button2 = "<a href=\"#\" class=\"buttons\" onClick=\"deleteRecord($id)\">Delete</a>";
	
	if ($forceEdit) {

		$number		= "&nbsp";
		$name 		= "<input name=\"name\"  id=\"name\" value=\"$name\"
					size=\"25\" maxlength=\"$chars_name\" type=\"text\">";
		$notes		= "<textarea name=\"notes\"  id=\"notes\">$notes</textarea>";
		$date		= "<input name=\"delivery_date\"  id=\"delivery_date\" value=\"$date\"
					size=\"12\" maxlength=\"$chars_date\" type=\"text\">";
		$person		= "<input name=\"person\"  id=\"person\" value=\"$person\"
					size=\"10\" maxlength=\"$chars_person\" type=\"text\">";

		$button1	= "<input onClick=\"saveRecord($id)\"   type=\"button\" value=\"Save\">";
		$button2	= "<input onClick=\"cancelRecord($id)\" type=\"button\" value=\"Cancel\">";
		
		$button1	= "<a href=\"#\" class=\"buttons\" onClick=\"saveRecord($id)\">Save</a>";
		$button2	= "<a href=\"#\" class=\"buttons\" onClick=\"cancelRecord($id)\">Cancel</a>";
	

	}
	
	if ($showButtons == 0) {
		$button1 = '&nbsp;';
		$button2 = '&nbsp;';
	}

	#$div	.= "<div class=\"projectDiv\" id=\"projectDiv$id\">\n";
	#$div	.= "<input type=\"$hiddenType\" name=\"id\" value=\"$id\" size=\"3\">\n";
	#$div	.= "  <table width=\"$w_t\" cellspacing=\"0\">\n";
	
	$div	.= "    <tr>\n";
	$div	.= "      <td width=\"$w1\">$number</td>\n";
	$div	.= "      <td width=\"$w2\">$name</td>\n";
	$div	.= "      <td width=\"$w3\" valign=\"top\"><pre>$notes</pre></td>\n";
	$div	.= "      <td width=\"$w4\">$date</td>\n";
	$div	.= "      <td width=\"$w5\">$person</td>\n";
	$div	.= "      <td width=\"$w6\">&nbsp;</td>\n";
	$div	.= "      <td width=\"$w7\">$button1 $button2<div class=\"msgDiv\" id=\"msgDiv$id\"></div></td>\n";
	$div	.= "    </tr>\n";
	
	#$div	.= "  </table>\n";
	#$div	.= "</div>\n";
	
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

#end


?>