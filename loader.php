<?php 
/**
*	Last Update: 06.08.18 [DD.MM.YY]
*/

// PHP ENVIRONMENT

	$inclpath=substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/'));

	if(isset($_SERVER['WINDIR'])){
		ini_set('include_path', '.;'.$inclpath.'/');
	}else{
		ini_set('include_path', '.:'.$inclpath.'/');
	}

// --------------------------------------
// INCLUDING

	include_once 'incls/loader.vars.php';
	include_once 'incls/data.php';
	include_once 'incls/sql.php';

// --------------------------------------
// MAIN FUNCTIONS

	function debug() { // Для дебага с beautify
	    print "<pre>";
	    $_args=func_get_args();
	    for($i=0;$i<count($_args);$i++){
	    	print json_encode($_args[$i],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
	    }
	    print "</pre>";
	}
	function getExt($filename){
		return pathinfo($filename)['extension'];
	}
	function cURL_post($url,$pd){
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL=>$url,
			CURLOPT_POST=>true,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_SSL_VERIFYPEER=>false,
			CURLOPT_SSL_VERIFYHOST=>false,
			CURLOPT_POSTFIELDS=>$pd
		]);
		$result = json_decode(curl_exec($ch),true);
		return $result;
	}

// --------------------------------------

// MAIN CODE
	
	$_l_p=$_GET['_l_p'];
	unset($_GET['_l_p']);
	if($_l_p=="") $_l_p="index";
	if(preg_match("/loader\.php.*$/",$_SERVER["REQUEST_URI"])!==0){
		$_l_p=$_loader_page404;
		header("$_SERVER[SERVER_PROTOCOL] 404 Not Found",true,404);
	}
	if(preg_match("/[.\/]/",$_l_p)===1) $_l_p=preg_replace("/[.\/]/", "", $_l_p);


	if(!(bool)$_GET['ref']){
		if(!(bool)$_SERVER['HTTP_REFERER']){
			$_SERVER['HTTP_REFERER']='/';
		}
	}else{
		$_SERVER['HTTP_REFERER']=$_GET['ref'];
	}

	if(file_exists("incls/main.php")){
		include_once 'incls/main.php';
		if(function_exists("main")) main();
	}

	if(isset($_l_p)){
			if(file_exists("views/$_l_p.php") && file_exists("models/$_l_p.php")){
				include_once "models/$_l_p.php";
				include_once "views/$_l_p.php";
			}else
			if(file_exists("func/$_l_p.php")){
				include_once "func/$_l_p.php";
			}else{
				header("$_SERVER[SERVER_PROTOCOL] 404 Not Found",true,404);
				if(file_exists("views/$_loader_page404.php") && file_exists("models/$_loader_page404.php")){
					include_once "models/$_loader_page404.php";
					include_once "views/$_loader_page404.php";
				}else print "404 Not Found";
			} 
	}

// --------------------------------------
?>