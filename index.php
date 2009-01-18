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

$date		= strftime("%d-%m-%Y");
$time		= strftime("%H:%M:%S");

$title		= 'DC-Technology Task List';
$msg		= '';

$R		= '<br />';

$hiddenType	= 'text';

$msg		= ''; //"FLAG: $flag IDNUM: $idnum";

$w1		= 10;
$w2		= 200;
$w3		= 400;
$w4		= 90;
$w5		= 70;
$w6		= 180;
$w_t		= $w1+$w2+$w3+$w4+$w5+$w6;

################################################################
## DB
################################################################

include('include/db.php');
$msg = createDB();

################################################################
## form variables
################################################################

$flag	= getVar('flag', 0);
$idnum	= getVar('idnum', 0);

if ($flag == 'save') {

	$name	= getVar('name');
	$notes	= getVar('notes');
	$date	= getVar('date');
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

if (!$msg == '') $msg = '<br /><span class="red">' . $msg . '</span><br />';

include('include/html.php');

echo $html;

################################################################
## p
################################################################

function getVar($s, $check=1) {

	global $msg, $flag, $idnum;
	
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

function rowHTML($forceEdit, $id, $number, $name, $notes, $date, $person) {

	global $flag;
	global $hiddenType;
	global $chars_number, $chars_name, $chars_notes, $chars_date, $chars_person;
		
	global $w1, $w2, $w3, $w4, $w5, $w6;
	
	$table	= '';
	
	$buttons  = "        <input onClick=\"editRecord($id)\" type=\"button\" value=\"Edit\">\n";
	$buttons .= "        <input onClick=\"deleteRecord($id)\" type=\"button\" value=\"Delete\">\n";

	if ($forceEdit) {

		$name = "<input name=\"name\"  id=\"name\" value=\"$name\"
			size=\"30\" maxlength=\"$chars_name\" type=\"text\">";
		#$notes = "<input name=\"notes\"  id=\"notes\" value=\"$notes\"
		#	size=\"70\" maxlength=\"$chars_notes\" type=\"text\">";
		$notes = "<textarea name=\"notes\"  id=\"notes\">$notes</textarea>";
		$date = "<input name=\"date\"  id=\"date\" value=\"$date\"
			size=\"12\" maxlength=\"$chars_date\" type=\"text\">";
		$person = "<input name=\"person\"  id=\"person\" value=\"$person\"
			size=\"10\" maxlength=\"$chars_person\" type=\"text\">";

		$buttons  = "      <input onClick=\"saveRecord($id)\"   type=\"button\" value=\"Save\">\n";
		$buttons .= "      <input onClick=\"cancelRecord($id)\" type=\"button\" value=\"Cancel\">\n";

	}

	$table .= "  <tr>\n";
	$table .= "    <td width=\"$w1\">$number</td>\n";
	$table .= "    <td width=\"$w2\">$name</td>\n";
	$table .= "    <td width=\"$w3\">$notes</td>\n";
	$table .= "    <td width=\"$w4\">$date</td>\n";
	$table .= "    <td width=\"$w5\" align=\"center\">$person</td>\n";
	$table .= "    <td width=\"$w6\" class=\"title\">\n";
	$table .= "$buttons";
	$table .= "        <input type=\"$hiddenType\" name=\"id\" value=\"$id\" size=\"3\">\n";
	$table .= "    </td>\n";
	$table .= "  </tr>\n";
	
	return $table;
}

################################################################
## BuildTable
################################################################

function BuildTable() {

	global $flag, $idnum;
	
	$table	= '';
	$ra	= getRecords();
	$number = 0;
	
	if ($flag == 'add') {
		$flag == 'edit';
		$table .= rowHTML(1, -1, '', '', '', '', '');
	}
	
	foreach ($ra as $entry) {
	
		$number++;
		$id	= $entry['id'];
		$name	= $entry['name'];
		$notes	= $entry['notes'];
		$date	= $entry['date'];
		$person	= $entry['person'];
	
		$forceEdit = 0;
		if ( ($flag == 'edit') && ($id == $idnum) ) $forceEdit = 1;

		$table .= rowHTML($forceEdit, $id, $number, $name, $notes, $date, $person);
	}
	
	return $table;
}

################################################################

#end


?>