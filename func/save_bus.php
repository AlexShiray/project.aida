<?php 
	$trans=checkbool(sqlsafe('trans'),"Не выбран транспортер"); // получение данных, проверка на пустоту и экранирование
	$price=checkbool(sqlsafe('price'),"Не выбрана цена");
	$weeks=sqlsafe('en_week');
	$weeks_selstation=sqlsafe("week_selstation");
	$weeks_recstation=sqlsafe("week_recstation");
	$weeks_seltime=sqlsafe("week_seltime");
	$weeks_rectime=sqlsafe("week_rectime");
	$editid=sqlsafe("editid");

	if((bool)$editid){ // для изменения существующего рейса
		if(sendquery("UPDATE bus SET price='$price', trans='$trans' WHERE id='$editid'")){
			$exists_weeks="";
			foreach($weeks as $k=>$dayname){
				$selstation=checkbool($weeks_selstation[$dayname],"Не выбрана станция отправления"); // доп. параметры
				$seltime=checkbool($weeks_seltime[$dayname],"Не выбрано время отправления");
				$recstation=checkbool($weeks_recstation[$dayname],"Не выбрана станция назначения");
				$rectime=checkbool($weeks_rectime[$dayname],"Не выбрано время назначения");

				$isexists=sendquery("SELECT id FROM bus_chart WHERE bus_id='$editid' AND week_day='$dayname'")[0]['id'];

				if((bool)$isexists){
					if(!sendquery("UPDATE bus_chart SET sel_station='$selstation',sel_time='$seltime',rec_station='$recstation',rec_time='$rectime' WHERE id='$isexists'")) backerror("Ошибка MySQL");
				}else{
					if(!sendquery("
						INSERT IGNORE INTO bus_chart (bus_id,week_day,sel_station,sel_time,rec_station,rec_time) 
						VALUES ('$editid','$dayname','$selstation','$seltime','$recstation','$rectime')")) backerror("Ошибка MySQL");
				}

				if($exists_weeks!="") $exists_weeks.=" AND ";
				$exists_weeks.="week_day!='$dayname'";
			}
			sendquery("DELETE FROM bus_chart WHERE bus_id='$editid' AND ($exists_weeks)"); // Удаление невыбранных расписаний
			backsuccess();
		}else backerror("Ошибка MySQL");
	}else{ // для создания нового рейса
		$newid=sendquery("INSERT INTO bus (price,trans) VALUES ('$price','$trans')");
		if((bool)$newid){
			foreach($weeks as $k=>$dayname){
				$selstation=checkbool($weeks_selstation[$dayname],"Не выбрана станция отправления"); // доп. параметры
				$seltime=checkbool($weeks_seltime[$dayname],"Не выбрано время отправления");
				$recstation=checkbool($weeks_recstation[$dayname],"Не выбрана станция назначения");
				$rectime=checkbool($weeks_rectime[$dayname],"Не выбрано время назначения");

				if(!sendquery("
					INSERT IGNORE INTO bus_chart (bus_id,week_day,sel_station,sel_time,rec_station,rec_time) 
					VALUES ('$newid','$dayname','$selstation','$seltime','$recstation','$rectime')")) backerror("Ошибка MySQL");
			}
			backsuccess();
		}else backerror("Ошибка MySQL");
	}
?>