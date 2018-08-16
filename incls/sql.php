<?php 

// Standart Variables
$adb_mys=NULL;				// MySQLi Resource (for function style)

$adb_host=HOST; 		// Host
$adb_user=USER; 			// User
$adb_password=PASS; 			// Password
$adb_db=DB; 			// Database
$adb_errlog=NULL; 			// Error Log File (empty = print error on screen)

/**
Usage:

Object-oriented style:
	$something=new mysql_db([host, user, password, database[, errorlog]]);
	$out=$something->sendquery(<query>);

Function style:
	$out=sendquery();

	IMPORTANT! 
	For this method <host>, <user>, <password>, <database>, <errorlog> uses from Standart variables

Shielding variables:
	Object-oriented style:
		$variable=$something->sqlsafe(<POST or GET name or string>);

	Function style:
		$variable=sqlsafe(<POST or GET name or string>);
*/

class mysql_db{
	public $mys;
	public $errlog=NULL;
	public $tz='0';					// Timezone for error logs (if errorlog not empty)
	public $throwerr=false;			// If <true> then errors throwed without processing

	function __construct($host=NULL, $user=NULL, $pass=NULL, $db=NULL, $errlog=NULL) { 
		// Fill this variables if you want to connect to other mysqli server (Default: Standart Variables)
		global $adb_host,$adb_user,$adb_password,$adb_db,$adb_errlog;
		!(bool)$host 	?	$host=$adb_host			:NULL;
		!(bool)$user 	?	$user=$adb_user			:NULL;
		!(bool)$pass 	?	$pass=$adb_password		:NULL;
		!(bool)$db 		? 	$db=$adb_db				:NULL;
		$this->errlog=(bool)$errlog 	?	$errlog 	:$adb_errlog;
		$this->mys = new mysqli($host, $user, $pass, $db) or $this->throwerror($this->mys->connect_error);
		mysqli_query($this->mys, "SET NAMES utf8");
	}

	public function sqlsafe($arg) {
		return sqlsafe($arg);
	}

	private function throwerror($error) {
		$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
		$stack = $stack[count($stack)-1];
		if($error=='' && (bool)$e) throw $e;
		if($this->throwerr) {
			throw new Exception($error);
		}else{
			if((bool)$this->errlog) {
				$f=fopen($this->errlog, 'a');
				fwrite($f, date('d.m.Y H:i', time()+60*60*$this->tz) ." | $error | F:$stack[file] | L:$stack[line]\n");
				fclose($f);
				die("An error with MYSQL has occured. Don't worry, we save it to log.");
			} else {
				die("<b>MySQL error: </b>$error<br />in file <b>$stack[file]</b><br />on line <b>$stack[line]</b>");
			}
		}
	}

	public function sendquery($query, $type=MYSQLI_ASSOC) {
		try{
			$_out=NULL;
			if(count(preg_split("/;/", $query))-1>1) {
				$_result=$this->mys->multi_query($query);
				if(gettype($_result)=='boolean'){
					$insertid=$this->mys->insert_id;
					if((bool)$insertid){
						return $insertid;
					}
					if((bool)$_result){
						// var_dump($_result);
						if($_result===true){
							$_out=$_result;
						}else{
							$_out=$_result->fetch_all($type);
							// var_dump($_out);
							$_result->free();
						}
					}else{
						if((bool)$this->mys->error){
							$this->throwerror($this->mys->error);
						}else $_out=$_result;
					}
				}
				$_i=0;
				$_out=[];
				while(true){
					if($_result!==false){
						$buff=$this->mys->store_result();
						if($buff!==false){
							$_out[$_i]=$buff->fetch_all($type);
						}else{
							if((bool)$this->mys->error){
								$this->throwerror($this->mys->error);
							}
						}
						if($this->mys->more_results()){
							$this->mys->next_result();
							$_i++;
						}else{
							break;
						}
					}else $this->throwerror($this->mys->error);
				}
			}else{
				$_result=$this->mys->query($query);
				$insertid=$this->mys->insert_id;
				// var_dump($_result,$insertid);
				if((bool)$insertid){
					return $insertid;
				}
				if((bool)$_result){
					//var_dump($_result->fetch_array());
					if($_result===true){
						$_out=$_result;
					}else{
						$_out=$_result->fetch_all($type);
						// var_dump($_out);
						$_result->free();
					}

				}else{
					if((bool)$this->mys->error){
						$this->throwerror($this->mys->error);
					}else $_out=$_result;
				}
			}
			// var_dump($_out);
			if(gettype($_out)==='boolean') return $_out;
			if(count($_out)==0){
				return NULL;
			}else{
				// if(count($_out)==1 && gettype($_out)!='boolean') return $_out[0];
				return $_out;
			}
		}catch(Exception $e){
			$this->throwerror($this->mys->error);
		}
	}
}

function _sqlsafe_array($arr){
	foreach($arr as $k=>$v){
		if(gettype($v)==='array'){
			$arr[$k]=_sqlsafe_array($v);
		}else{
			$arr[$k]=htmlspecialchars(trim(addslashes($v)));
		}
	}
	return $arr;
}

function sqlsafe($arg){ 
	if(!is_null($arg)){
		if(isset($_POST[$arg])){
			$out=$_POST[$arg];
		}elseif(isset($_GET[$arg])){
			$out=$_GET[$arg];
		}else return NULL;
		if(gettype($out)==='array'){
			return _sqlsafe_array($out);
		}else{
			return htmlspecialchars(trim(addslashes($out)));
		}
	}else{
		return NULL;
	}
}

function sendquery($query,$type=MYSQLI_ASSOC){ 
	global $adb_mys;
	if(!(bool)$adb_mys){
		$adb_mys=new mysql_db();
	}
	return $adb_mys->sendquery($query,$type);
}
?>