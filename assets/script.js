
var lastID = -1

/* ********************************************** */

$(document).ready(function(){ 

	//v = $(myLay).css("top")
	//$("#msgDiv").css("top", v  + "px");
	//$(':button:contains(My Button)').click(changeClass);
	//$("#pp").click(changeClass);
	//$("#pp").css("padding", 100 + "px")
	
});

/* ********************************************** */

function editValue(n) {
	
	if (n == lastID) return
	
	if (lastID != -1) {
		lastID.innerHTML = document.getElementById('editing').value
		//alert($(lastID + " :editing").text())
		//$(lastID).text($("editing").text())
	}
	
	lastID = n
	
	v = n.innerHTML
	//n.innerHTML = "<input id=\"editing\" value=\"" + v + "\">"
	n.innerHTML = "<textarea id=\"editing\">" + v + "</textarea>"
}

/* ********************************************** */

function showEdit(n) {
	if (n > 0) {
		v = document.getElementById('name');
		if (v == null) return
		v.focus()
		document.mainform.flag.value = "edit" + n
	}
}

function logIn() {
	var v = document.getElementById('username').value;
	if (v == '') return
	var v = document.getElementById('password').value;
	if (v == '') return

	document.loginform.submit();
}

function logInEASY() {
	
	//var pw = prompt("Enter password", "");
	var pw = document.getElementById('password').value;
	
	if (pw == 'dct') {
		document.mainform.loggedin.value = '1'
		document.mainform.flag.value = ''
	}
	
	document.mainform.submit();
}

function logOut() {
	document.mainform.idnum.value = ''
	document.mainform.flag.value = 'logout'
	document.mainform.submit();
}

function logOutEASY() {
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

	if (n == lastID) return
	
	s = ""
	s = s + "<div class=\"buttons\"><a href=\"#\" onClick=\"deleteRecordNow(" + n + ")\">YES</a><span></span></div>"
	s = s + "<div class=\"buttons\"><a href=\"#\" onClick=\"cancelRecord(0)\">NO</a><span></span></div>"
	
	msgLayer = document.getElementById('msgDiv' + n);
	msgLayer.innerHTML = s;
	
	deleteLast(n) 
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

function deleteLast(n) {

	if (lastID > -1) {
		lastDiv = document.getElementById('msgDiv'+lastID)
		lastDiv.innerHTML = '';
	}
	
	lastID = n
}

function saveRecord(n) {
	
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
	
	v = document.getElementById('delivery_date');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter a delivery date first!"
		v.focus()
	}
	
	v = document.getElementById('person');
	if ( (fail == 0) && (v.value == '') ) {
		fail = 1
		msg = "Enter a person's name first!"
		v.focus()
	}

	deleteLast(n) 
	
	msgLayer = document.getElementById('msgDiv' + n);
	msgLayer.innerHTML = msg;
	msgLayer.top = 125 + 'px';
	//dump(msg.innerHTML)
	
	if (fail == 0) {
		document.mainform.idnum.value = n
		document.mainform.flag.value = 'save'
		document.mainform.submit();
	}
}
