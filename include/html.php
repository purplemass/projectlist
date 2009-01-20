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

$focusName	 = 0;
$topButtons	 = "<input type=\"button\" name=\"add\" value=\"Add Record\" onClick=\"addRecord()\">&nbsp;";
$topButtons	.= "<input type=\"button\" name=\"logout\" value=\"Logout\" onClick=\"logOut()\">";

if ( ($flag == 'edit') || ($flag == 'add') || ($loggedin != 1) ) {
	$topButtons	= "<input type=\"button\" name=\"login\" value=\"Login\" onClick=\"logIn()\">";
	$focusName	= 1;
}

$msgDiv = "<div id=\"msgDiv\">$msg&nbsp;</div>";
if ($msg == '') $msgDiv = '';

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

<script type="text/javascript">

function showEdit(n) {
	if (n > 0) {
		v = document.getElementById('name');
		if (v == null) return
		v.focus()
		document.mainform.flag.value = "edit" + n
	}
}

function logIn() {
	var pw = prompt("Enter password", "");
	if (pw == 'dct') {
	document.mainform.loggedin.value = '1'
	document.mainform.flag.value = ''
	}
	document.mainform.submit();
}

function logOut() {
	document.mainform.loggedin.value = ''
	cancelRecord(0)
}

function addRecord(n) {
	document.mainform.idnum.value = ''
	document.mainform.flag.value = 'add'
	document.mainform.submit();
}

function cancelRecord(n) {
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'cancel'
	document.mainform.submit();
}

function deleteRecord(n) {
	msgLayer = document.getElementById('msgDiv');
	s = "Delete Project #" + n + "? <a href=\"#\" onClick=\"deleteRecordNow(" + n + ")\">YES</a> "
	s = s + "<a href=\"#\" onClick=\"cancelRecord(0)\">NO</a>"
	msgLayer.innerHTML = s;
}

function deleteRecordNow(n) {
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'delete'
	document.mainform.submit();
}

function editRecord(n) {
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'edit'
	document.mainform.submit();
}

function saveRecord(n) {
	
	msgLayer = document.getElementById('msgDiv');
	msg = ''
	
	fail = 0
	v = document.getElementById('name');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter a name first!"
		v.focus()
	}
	
	v = document.getElementById('notes');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter some notes first!"
		v.focus()
	}
	
	v = document.getElementById('date');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter a date first!"
		v.focus()
	}
	
	v = document.getElementById('person');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter a person's name first!"
		v.focus()
	}

	msgLayer.innerHTML = msg;
	//dump(msg.innerHTML)
	
	if (fail == 0) {
		document.mainform.idnum.value = n
		document.mainform.flag.value = 'save'
		document.mainform.submit();
	}
}

</script>


<style>

* {
	margin: 0
	padding: 0;
}

body {
	font-family: Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px;
	padding: 10px;
}

a {
	color: red;
	text-decoration: underline;
}

input, select {
	font-family: Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px;
}

textarea {
	font-family: Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px;
	width: 350px;
	height: 50px;
}

table {
	font-size: 10px;
	border-top1: 3px #6699CC solid;
	background-color: #FFFFFF;
}

tr {
	height: 30px;
}

td {
	border-bottom: 1px #6699CC solid;
	border-collapse: collapse;
	border-spacing: 0px;
	margin: 0;
	padding: 2px;
	vertical-align: top;
}

pre {
	font-family: Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px;
	margin: 0;
}

.title {
	font-weight: bold;
	vertical-align: middle;
}

.buttons {
	width: 72px;
}

/*
	float: right;
	background-color: #6699CC;
*/

#msgDiv {
	position: absolute;
	top: 30px;
	left: 810px;
	width: 170px;
	height: 14px;
	color: #FF0000;
	margin-top: 10px;
	padding: 5px;
	font-size: 10px;
	font-weight: bold;
	text-align: left;
	vertical-align: center;
}

</style>

</head>
<body onLoad="showEdit($focusName)">
<b><font size="4">$title</font></b>
$msgDiv
<br /><br />$displayDate $displayTime
<br /><br />
<form method="POST" action="$thisScript" name="mainform" id="mainform">
<!-- input type="button" name="logon" value="Log On" onClick="logOn" -->
<input type="$hiddenType" name="flag" value="$flag">
<input type="$hiddenType" name="idnum" value="$idnum">
<input type="$hiddenType" name="loggedin" value="$loggedin">
<table cellspacing="0"><!-- width="$w_t" -->
  <tr>
    <td width="$w1" class="title">#</td>
    <td width="$w2" class="title">Name</td>
    <td width="$w3" class="title">Notes</td>
    <td width="$w4" class="title">Delivery&nbsp;date</td>
    <td width="$w5" class="title">Assigned&nbsp;to</td>
    <td width="$w6" class="title">
      $topButtons
    </td>
  </tr>
</table>
$table
</form>
</body>
</html>

EOF;

################################################################

#end

?>