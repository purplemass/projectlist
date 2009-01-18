<?php

################################################################

# db.php
# database handling (sqlite2)
# bhat/imagination/17.01.2009

# DC-Technology internal project - 2009

# bhat/imgination/17.01.2009: version 1.0

################################################################
## variables
################################################################

$chars_name	= 100;
$chars_notes	= 256;
$chars_date	= 10;
$chars_person	= 10;

//$dbPath	= $_SERVER['DOCUMENT_ROOT'].'list/taskList.sqlite2';
$dbPath		= 'taskList.sqlite2';
$dbHandle	= 0;

################################################################
## createDB
################################################################

function createDB() {

	global $dbPath, $dbHandle;
	
	global $chars_name, $chars_notes, $chars_date, $chars_person;
	
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
		$cmd = "CREATE TABLE list(
					id INTEGER PRIMARY KEY NOT NULL,
					name CHAR($chars_name),
					notes CHAR($chars_notes),
					date CHAR($chars_date),
					person CHAR($chars_person)
					)";
		dbExec($cmd);

		//?? $pageVisit = sqlite_escape_string($_SERVER['PHP_SELF']);
		
		insertRecords();
		
		return "Database created in '$dbPath' with 3 dummy records";
	
	} else {
	
		return '';
	
	}
}

################################################################
## insertRecords
################################################################

function insertRecords() {

	global $dbHandle;
	
	dbExec("INSERT INTO list (name, notes, date, person)
		VALUES ('PROJECT1', 'some notes', '17-01-2009', 'bob')");
	dbExec("INSERT INTO list (name, notes, date, person)
		VALUES ('PROJECT2', 'some notes', '18-01-2009', 'max')");
	dbExec("INSERT INTO list (name, notes, date, person)
		VALUES ('PROJECT3', 'some notes', '19-01-2009', 'andrew')");
		
}

################################################################
## saveRecord
################################################################

function saveRecord($id) {

	global $name, $notes, $date, $person;
	
	dbExec("UPDATE list SET name='$name', notes='$notes', date='$date', person='$person'
		WHERE id='$id'");

}
################################################################
## deleteRecord
################################################################

function deleteRecord($id) {
	dbExec("DELETE FROM list WHERE id=$id");
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