<?php
/*
**	@desc:		PHP ajax login form using jQuery
**	@author:	programmer@chazzuka.com
**	@url:		http://www.chazzuka.com/blog
**	@date:		15 August 2008
**	@license:	Free!, but i'll be glad if i my name listed in the credits'
*/

//@ validate inclusion
if(!defined('VALID_ACL_')) exit('direct access is not allowed.');

define('USEDB',		false);		//@ use database? true:false
define('LOGIN_METHOD',	'both');	//@ 'user':'email','both'
define('SUCCESS_URL',	'index.php');	//@ redirection target on success

//@ you could delete one of block below according to the USEDB value
if(USEDB) 
{
	$db_config = array(
		'server'	=>	'localhost',	//@ server name or ip address along with suffix ':port' if needed (localhost:3306)
		'user'		=>	'xxxx',			//@ mysql username
		'pass'		=>	'xxxx',	//@ mysql password
		'name'		=>	'db_test',		//@ database name
		'tbl_user'	=>	'tbl_user'		//@ user table name
		);
}
else
{
	$user_config = array(
		array(
			'username'	=>	'admin',
			'useremail'	=>	'admin@localhost',
			'userpassword'	=>	'e10adc3949ba59abbe56e057f20f883e',	// md5:123456
		),
		array(
			'username'	=>	'user',
			'useremail'	=>	'user@localhost',
			'userpassword'	=>	'e10adc3949ba59abbe56e057f20f883e',	// md5:123456
		)	
	);
}

?>