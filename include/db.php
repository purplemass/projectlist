<?php

################################################################

# db.php
# database handling (sqlite2)
# bhat/imagination/17.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/17.01.2009: version 1.0

################################################################
## init
################################################################

include_once('include/common.php');

################################################################
## variables
################################################################

//$dbPath	= $_SERVER['DOCUMENT_ROOT'].'list/taskList.sqlite2';
$dbPath		= 'assets/projectlist.sqlite2';
$dbHandle	= 0;

################################################################
## createDB
################################################################

//include_once('sqlite/sqlite_driver.php');

function createDB() {

	global $dbPath, $dbHandle;
	
	global $BL;
	
	if (!file_exists($dbPath)) {
/*
		// create a SQLite2 database file and return a database handle (Object Oriented)
		try {
			$dbHandle = new SQLiteDatabase($dbPath, 0666);
		} catch( Exception $exception ) {
			die($exception->getMessage());
		}
*/
		// open database file and return a database handle
		$dbHandle = sqlite_open($dbPath, 0666, $sqliteError) or die($sqliteError);

		// create page view database table //number INTEGER($chars_number),
		$cmd = "CREATE TABLE list (
					id INTEGER PRIMARY KEY NOT NULL,
					name CHAR(" . $BL['name']['size'] . "),
					notes CHAR(" . $BL['notes']['size'] . "),
					enddate CHAR(" . $BL['enddate']['size'] . "),
					person CHAR(" . $BL['person']['size'] . ")
					)";
		dbExec($cmd);

		$cmd = "CREATE TABLE user (
					id INTEGER PRIMARY KEY NOT NULL,
					username CHAR(" . $BL['name']['size'] . "),
					password CHAR(" . $BL['name']['size'] . "),
					creationdate CHAR(" . $BL['enddate']['size'] . ")
					)";
		dbExec($cmd);
		
		//?? $pageVisit = sqlite_escape_string($_SERVER['PHP_SELF']);
		
		$n = 10;
		insertRecords($n);
		
		return "Database created in '$dbPath' with $n dummy records";
	
	} else {
	
		return '';
	
	}
}

################################################################
## insertRecords
################################################################

function insertRecords($n) {

	global $dbHandle;
	
	dbExec("INSERT INTO user (username, password, creationdate)
				VALUES ('admin', 'dct', '28-01-2009')");
	for ($i=1; $i<($n+1); $i++) {
		dbExec("INSERT INTO list (name, notes, enddate, person)
				VALUES ('PROJECT$i', 'some notes for project $i', '17-01-2009', 'bob')");
	}	
}

################################################################
## addRecord
################################################################

function addRecord($name, $notes, $enddate, $person) {
	
	dbExec("INSERT INTO list (name, notes, enddate, person)
		VALUES ('$name', '$notes', '$enddate', '$person')");
}

################################################################
## saveRecord
################################################################

function saveRecord($id, $name, $notes, $enddate, $person) {
	
	dbExec("UPDATE list SET name='$name', notes='$notes', enddate='$enddate', person='$person'
		WHERE id='$id'");

}
################################################################
## deleteRecord
################################################################

function deleteRecord($id) {
	dbExec("DELETE FROM list WHERE id=$id");
}

################################################################
## getUserDetails
################################################################

function getUserDetails($s) {

	global $dbPath, $dbHandle;
	
	if ($dbHandle == 0) $dbHandle = sqlite_open($dbPath, 0666, $sqliteError) or die("SQL error: $sqliteError");
	
	#$ra = sqlite_array_query($dbHandle, 'SELECT * FROM user WHERE username=\'$s\'');
	$ra = sqlite_array_query($dbHandle, "SELECT * FROM user where username='$s'");

	#echo "<pre>\n";
	#print_r($ra);
	#echo "<pre>\n";
		
	return $ra;
	
}

################################################################
## getRecords
################################################################

function getRecords() {

	global $dbPath, $dbHandle;
	
	if ($dbHandle == 0) $dbHandle = sqlite_open($dbPath, 0666, $sqliteError) or die("SQL error: $sqliteError");
	
	//NO! $ra = sqlite_fetch_array(dbQuery("select id from list"));
	$ra = sqlite_array_query($dbHandle, 'SELECT * FROM list LIMIT 200');

	/*
	echo "<pre>\n";
	print_r($ra);
	echo "<pre>\n";
	
	//var_dump(sqlite_fetch_array($result));

	*/

	return $ra;
	
}

################################################################
# dbExec
################################################################

function dbQuery($cmd) {

	global $dbPath, $dbHandle;
	
	if ($dbHandle == 0) $dbHandle = sqlite_open($dbPath, 0666, $sqliteError) or die("SQL error: $sqliteError");
	
	$query = sqlite_query($dbHandle, $cmd, $error);

	if (!$query) {
		exit("Error in query: '$error'");
	} else {
		//p('Number of rows modified: ', sqlite_changes($dbHandle));
	}
	
	return $query;
}

################################################################
# dbExec
################################################################

function dbExec($cmd) {

	global $dbPath, $dbHandle;
	
	if ($dbHandle == 0) $dbHandle = sqlite_open($dbPath, 0666, $sqliteError) or die($sqliteError);
	
	$query =  sqlite_exec($dbHandle, $cmd, $error);

	if (!$query) {
		exit("Error in query: '$error'");
	} else {
		//p('Number of rows modified: ', sqlite_changes($dbHandle));
	}
	
	//return $query;
}

################################################################

#end

?>