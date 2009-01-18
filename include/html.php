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
	document.mainform.idnum.value = n
	document.mainform.flag.value = 'save'
	document.mainform.submit();
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

input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	padding=0;
	margin=0;
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

.red {
	color: red;
}

.title {
	font-weight: bold;
}

table {
	background1-color: #aa2345;
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
<br /><br />$date $time
<br />$msg<br />
<form method="POST" action="$thisScript" name="mainform" id="mainform">
<input type="button" name="add"   value="Add Record" onClick="addRecord()">
<!-- input type="button" name="logon" value="Log On"     onClick="logOn" -->
<br />
<input type="$hiddenType" name="flag" value="$flag">
<input type="$hiddenType" name="idnum" value="$idnum">
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