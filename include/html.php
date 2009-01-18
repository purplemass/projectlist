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

df = document.mainform

function showEdit(n) {
	if (n > 0) {
		document.mainform.flag.value = "edit" + n
	}
}

function addRecord(n) {
	document.mainform.idnum.value = ''
	document.mainform.flag.value = 'add'
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
		msg = "Enter a date (dd-mm-yyy) first!"
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

function cancelRecord(n) {
	document.mainform.idnum.value = ''
	document.mainform.flag.value = 'cancel'
	document.mainform.submit();
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

* {
	margin: 0;
	padding: 0;
}

body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	padding: 10px;
}

#msgDiv {
	margin-top: 10px;
	padding: 2px;
	color: white;
	font-size: 12px;
	font-weight: bold;
	background-color: #AAAAAA;
}

input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	padding: 0;
	margin: 0;
	width: 72px;
}

select {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

textarea {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	width: 380px;
	height: 50px;
}

.title {
	font-weight: bold;
	vertical-align: middle;
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
	vertical-align: top;
}

</style>

</head>
<body onLoad="showEdit($editMode)">
<b><font size="4">$title</font></b>
<br /><br />$displayDate $displayTime
<br /><div id="msgDiv">$msg&nbsp;</div>
<form method="POST" action="$thisScript" name="mainform" id="mainform">
<!-- input type="button" name="logon" value="Log On"     onClick="logOn" -->
<input type="$hiddenType" name="flag" value="$flag">
<input type="$hiddenType" name="idnum" value="$idnum">
<table width="$w_t" cellspacing="0">
  <tr>
    <td width="$w1" class="title">#</td>
    <td width="$w2" class="title">Name</td>
    <td width="$w3" class="title">Notes</td>
    <td width="$w4" class="title">Date</td>
    <td width="$w5" class="title">Assigned to</td>
    <td width="$w6" class="title">
      <input type="button" name="add"   value="Add Record" onClick="addRecord()">
    </td>
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