<?php 
	$buses=sendquery("SELECT * FROM bus ORDER BY id DESC");
	function getBusChart($busid){
		return sendquery("SELECT * FROM bus_chart WHERE bus_id='$busid'");
	}
?>