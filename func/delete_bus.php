<?php 
	$id=checkbool(sqlsafe("id"),"Неверный ID"); // проверка на пустоту и экранирование 
	$isexists=sendquery("SELECT id FROM bus WHERE id='$id'")[0]['id']; // проверка на существование
	if((bool)$isexists){
		sendquery(" 
			DELETE FROM bus WHERE id='$id';
			DELETE FROM bus_chart WHERE bus_id='$id';
		"); // Удаление
			backsuccess();
	}else backerror("Рейса не существует");
?>
