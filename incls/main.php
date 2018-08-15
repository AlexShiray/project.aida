<?php 
	function main(){
		// Your code here
	}
	function backerror($error){
		print "
		<meta charset=utf-8>
		<script>
			alert(\"Возникла ошибка:\\n\\n$error\");
			location.href='$_SERVER[HTTP_REFERER]';
		</script>
		";
		die();
	}
	function backsuccess(){
		print "
		<meta charset=utf-8>
		<script>
			alert('Успешно!');
			location.href='$_SERVER[HTTP_REFERER]';
		</script>
		";
		die();
	}
	function checkbool($str,$error){
		if((bool)$str){
			return $str;
		}else{
			backerror($error);
		}
	}
?>