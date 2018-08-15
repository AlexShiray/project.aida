<?php 
	$id=checkbool(sqlsafe("id"),"Неверный ID");
	$isexists=sendquery("SELECT id FROM bus WHERE id='$id'")[0]['id'];
	if((bool)$isexists){
		sendquery("
			DELETE FROM bus WHERE id='$id';
			DELETE FROM bus_chart WHERE bus_id='$id';
		");
			backsuccess();
	}else backerror("Рейса не существует");
?>
