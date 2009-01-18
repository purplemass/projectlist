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

$title		= "DC-Technology Task List";
$msg		= "";

$w1		= 10;
$w2		= 200;
$w3		= 350;
$w4		= 70;
$w5		= 70;
$w6		= 150;
$w_t		= $w1+$w2+$w3+$w4+$w5+$w6;

$R		= '<br />';

$table		= '';
$hiddenType	= 'text';
$editMode	= 0;

################################################################
## form variables
################################################################

$flag		= $_POST["flag"];
$idnum		= $_POST["idnum"];
$msg		= "FLAG: $flag IDNUM: $idnum";

################################################################
## DB
################################################################

include('db.php');

$msg .= createDB();
if (!$msg == '') $msg = '<br /><span class="red">' . $msg . '</span><br />';

if ($flag == 'delete') deleteRecord($idnum);
if ($flag == 'edit') $editMode = $idnum;

BuildTable();

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
## BuildTable
################################################################

function BuildTable() {

	global $flag, $idnum, $table;
	
	$ra = getRecords();

	foreach ($ra as $entry) {
	
		$myid = strval($entry['id']);
		
		if (($flag == 'edit') && ($myid == $idnum)) {
		
			$table .= "		<tr>\n";
			$table .= "			<td width=\"$w1\">" . $entry['number'] . "</td>\n";
			$table .= "			<td width=\"$w1\"><input type=\"$hiddenType\" name=\"id\" value=\""
								. $entry['name'] . "\" size=\"40\" maxlength=\"3\"></td>\n";
			$table .= "			<td width=\"$w3\">" . $entry['notes'] . "</td>\n";
			$table .= "			<td width=\"$w4\">" . $entry['date'] . "</td>\n";
			$table .= "			<td width=\"$w5\" align=\"center\">" . $entry['person'] . "</td>\n";
			$table .= "			<td width=\"$w6\" class=\"title\">\n";
			$table .= "				<input type=\"$hiddenType\" name=\"id\" value=\""
								. $entry['id'] . "\" size=\"3\" maxlength=\"3\">\n";
			$table .= "				<input onClick=\"deleteRecord(". $entry['id'] . ")\"
								type=\"button\" value=\"Delete\">\n";
			$table .= "				<input  onClick=\"editRecord(". $entry['id'] . ")\"type=\"button\" value=\"Edit\">\n";
			$table .= "		</td>\n";
			$table .= "		</tr>\n";		
		
		} else {
		
			$table .= "		<tr>\n";
			$table .= "			<td width=\"$w1\">" . $entry['number'] . "</td>\n";
			$table .= "			<td width=\"$w2\">" . $entry['name'] . "</td>\n";
			$table .= "			<td width=\"$w3\">" . $entry['notes'] . "</td>\n";
			$table .= "			<td width=\"$w4\">" . $entry['date'] . "</td>\n";
			$table .= "			<td width=\"$w5\" align=\"center\">" . $entry['person'] . "</td>\n";
			$table .= "			<td width=\"$w6\" class=\"title\">\n";
			$table .= "				<input type=\"$hiddenType\" name=\"id\" value=\""
								. $entry['id'] . "\" size=\"3\" maxlength=\"3\">\n";
			$table .= "				<input onClick=\"deleteRecord(". $entry['id'] . ")\"
								type=\"button\" value=\"Delete\">\n";
			$table .= "				<input  onClick=\"editRecord(". $entry['id'] . ")\"type=\"button\" value=\"Edit\">\n";
			$table .= "		</td>\n";
			$table .= "		</tr>\n";
		
		}
		
	}

}

################################################################
## HTML
################################################################

print <<<EOF

<?xml version="1.0" encoding="ISO-8859-1" ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1 DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-quiv="pragma" content="no-cache">

<title>$title</title>

<script type="text/javascript">

function showEdit(n) {
	if (n > 0) {
		document.mainform.flag.value = "edit" + n
	}
}

function deleteRecord(n) {
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'delete'
	document.mainform.submit();
}

function editRecord(n) {
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'edit'
	document.mainform.submit();
}

</script>


<style>

body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px
}

input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	padding=0;
	margin=0;
}

select {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px
}

.red {
	color: red;
}

.title {
	font-weight: bold;
}

table {
	background-color: #FFFFFF;
}

td {
	border-bottom: 1px #6699CC solid;
	border-collapse: collapse;
	border-spacing: 0px;
	margin: 0;
	padding: 4px;
}

</style>

</head>
<body onLoad="showEdit($editMode)">
<b><font size="4">$title</font></b>
<br /><br />$date $time
<br />$msg<br />
<!-- <b><font size="4">$msg</font></b><br /><br /> -->
<form method="POST" action="$thisScript" name="mainform" id="mainform">
<input type="$hiddenType" name="flag" value="">
<input type="$hiddenType" name="idnum" value="">
<table width="$w_t" cellspacing="0">
	<tr>
		<td width="$w1" class="title">#</td>
		<td width="$w2" class="title">Name</td>
		<td width="$w3" class="title">Notes</td>
		<td width="$w4" class="title">Date</td>
		<td width="$w5" class="title">Assigned to</td>
		<td width="$w6" class="title">&nbsp;</td>
	</tr>
$table

</table>
</form>

</body>
</html>

EOF;

################################################################

#end


?>