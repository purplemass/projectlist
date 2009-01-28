
/* ********************************************** */

$(document).ready(function(){ 
});

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
	//var pw = prompt("Enter password", "");
	var pw = document.getElementById('password').value;
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
	
	myLay = ('#projectDiv'+n)
	v = $(myLay).css("top")
	$("#msgDiv").css("top", v  + "px"); 
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
	msgLayer.top = 125 + 'px';
	//dump(msg.innerHTML)
	
	if (fail == 0) {
		document.mainform.idnum.value = n
		document.mainform.flag.value = 'save'
		document.mainform.submit();
	}
}
