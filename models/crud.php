<?php 
	$buses=sendquery("SELECT * FROM bus ORDER BY id DESC"); // Массив для выдачи в таблицу
	function getBusChart($busid){ // Получение графика работ из php
		return sendquery("SELECT * FROM bus_chart WHERE bus_id='$busid'");
	}
?>