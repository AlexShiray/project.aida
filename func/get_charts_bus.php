<?php 
	$id=checkbool(sqlsafe("id"),"Неверный ID");
	$isexists=sendquery("SELECT id FROM bus WHERE id='$id'")[0]['id'];
	if((bool)$isexists){
		print json_encode([
			'status'=>true,
			'bus_chart'=>sendquery("SELECT week_day,sel_station,sel_time,rec_station,rec_time FROM bus_chart WHERE bus_id='$id'")
		],JSON_UNESCAPED_UNICODE);
	}else{
		print json_encode([
			'status'=>false,
			'error'=>'Такой рейс не найден'
		],JSON_UNESCAPED_UNICODE);
	}
?>