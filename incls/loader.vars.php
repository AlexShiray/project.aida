<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	// error_reporting(E_ALL & ~E_NOTICE);
	// error_reporting(E_ERROR);

	date_default_timezone_set("Etc/GMT+0");

	/*ini_set('session.name', 'SESSION');
	// ini_set('session.cookie_secure', '1');
	ini_set('session.cookie_httponly', '1');
	ini_set('session.gc_maxlifetime', '31536000');
	ini_set('session.cookie_lifetime', '31536000');
	session_start();*/

	$_loader_page404="404";
	$_loader_page403="403";
?>