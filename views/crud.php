<style>
	.subitem{
		border-right:solid 1px black;
		padding-right:2px;
		margin-right:2px;
	}
	a{
		color:#f31d2f;
	}
	.modal{
		display: none;
		position: absolute;
		top:15px;
		left:50%;
		transform:translateX(-50%);
		z-index:101;
		background:#fff;
		padding:3px;
		padding-left:5px;
	}
	.modal_fade{
		background:rgba(0,0,0,.5);
		display: none;
		position: fixed;
		z-index:100;
		left:0;
		top:0;
		width:100%;
		height: 100%;
	}
	.modal_fade.show,
	.modal.show{
		display:block;
	}
	.modal.chart{
		text-align: center;
	}
	.buses{
		width:100%;
	}
	td{
		text-align: center;
	}
</style>
<link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
<a href="#" onclick="edit_bus(0)">Добавить рейс</a>
<hr>
Рейсы: <br>
<table class="buses">
	<thead>
		<th>ID</th>
		<th>Цена</th>
		<th>Транспортер</th>
		<th>Действия</th>
	</thead>
	<tbody>
		<?if((bool)$buses)foreach($buses as $key=>$bus):?>
		<tr class="bus_item">
			<td><?=$bus['id']?></td>
			<td><?=$bus['price']?> тг.</td>
			<td><?=$bus['trans']?></td>
			<td>
				<a href="#" onclick="open_chart(<?=$bus['id']?>)">График поездок</a><br>
				<a href="#" onclick="edit_bus(<?=$bus['id']?>)">Изменить</a><br>
				<a href="./delete_bus?id=<?=$bus['id']?>">Удалить</a><br>
			</td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>
<div class="modal_fade" onclick="closemodal(document.querySelector('.modal.edit form'))"></div>
<div class="modal chart">
	<?$week_names=['mon','tue','wed','thu','fri','sat','sun'];
	$week_rus=['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье'];
	foreach($week_names as $k=>$dayname):?>
	<div class="control">
		<div class="control">
			<?=$week_rus[$k]?>
		</div>
		<table class="chart <?=$dayname?>">
			<tbody>
				<tr class="selstation">
					<td><b>Пункт отправления</b></td>
					<td class="val"></td>
				</tr>
				<tr class="seltime">
					<td><b>Время отправления</b></td>
					<td class="val" data-ttd_action="%hou%:%min%"></td>
				</tr>
				<tr class="recstation">
					<td><b>Пункт прибытия</b></td>
					<td class="val"></td>
				</tr>
				<tr class="rectime">
					<td><b>Время Прибытия</b></td>
					<td class="val" data-ttd_action="%hou%:%min%"></td>
				</tr>
				<tr class="duration">
					<td><b>Время поездки</b></td>
					<td class="val" data-ttd_action="%hou%:%min%" data-tdd_utc=true></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?endforeach;?>
</div>
<div class="modal edit">
	<form action="./save_bus" method=post>
		<div class="control">
			Транспортер: <input type="text" required="" name="trans" class="form-trans">
		</div>
		<div class="control">
			Цена рейса: <input type="number" required="" name="price" pattern="[\d]+" class="form-price">
		</div>
		<hr>
		<div class="control">
			<b>График поездок</b>
		</div>
		<?foreach($week_names as $k=>$dayname):?>
		<div class="control">
			<input type="checkbox" id="<?=$dayname?>" value="<?=$dayname?>" name="en_week[<?=$k?>]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="<?=$dayname?>"><?=$week_rus[$k]?></label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[<?=$dayname?>]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[<?=$dayname?>]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[<?=$dayname?>]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[<?=$dayname?>]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<?endforeach;?>
		<div class="control">
			<input type="hidden" name="editid" value="0" class="edit_id_hidden">
			<input type=submit value="Сохранить">
			<input type=button onclick="closemodal(this.parentElement.parentElement)" value="Отмена">
		</div>
	</form>
</div>
<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.full.js"></script>
<script>
	$.datetimepicker.setLocale('ru');
	$('.timepicker').datetimepicker({ // Фреймворк для jQuery
		format:"H:i",
		step:5,
		datepicker:false,
	});
	function convertToTs(self){ // Конвертирование в unixtime из ЧЧ:ММ
		let temp=new Date(),
			hours_mins=self.value.split(":");
		temp.setTime(0);
		temp.setMinutes(hours_mins[1]);
		temp.setHours(hours_mins[0]);
		self.nextElementSibling.nextElementSibling.value=temp.getTime()/1000;
	}
	function enable_week_control(self){ // Для чекбоксов в графике
		let controls=self.nextElementSibling.nextElementSibling;
		controls.querySelectorAll('input').forEach(function(elem) {
			elem.disabled=self.checked?null:true;
			elem.value="";
		});
	}
	function open_chart($busid){ // открытие модального окна графиков и его заполнение с помощью AJAX
		var xhr=new XMLHttpRequest();
		xhr.onload=function(){
			if(xhr.status===200){
				var d=JSON.parse(xhr.response),
					tables=['mon','thu','wed','tue','fri','sat','sun'];
				if(d.status===true){
					document.querySelectorAll('.chart').forEach(function(elem) {
						elem.parentElement.style.display="initial";
					});
					d.bus_chart.forEach(function(elem) {
						tables.splice(tables.indexOf(elem.week_day),1);
						let table=document.querySelector('.chart.'+elem.week_day),
							cont=table.querySelector('tbody'),
							selstation=cont.querySelector('.selstation .val'),
							seltime=cont.querySelector('.seltime .val'),
							recstation=cont.querySelector('.recstation .val'),
							rectime=cont.querySelector('.rectime .val'),
							duration=cont.querySelector('.duration .val');
						selstation.innerText=elem.sel_station;
						seltime.innerText=elem.sel_time;
						recstation.innerText=elem.rec_station;
						rectime.innerText=elem.rec_time;
						if(elem.rec_time>=elem.sel_time){
							duration.innerText=(parseInt(elem.rec_time)-parseInt(elem.sel_time));
						}else{
							duration.innerText=((86400-parseInt(elem.sel_time))+parseInt(elem.rec_time));
						}
						seltime.classList.add('timestamp_to_date');
						rectime.classList.add('timestamp_to_date');
						duration.classList.add('timestamp_to_date');
						timestampsToDate();
					});
					tables.forEach(function(elem) {
						document.querySelector('.chart.'+elem).parentElement.style.display='none';
					});
					document.querySelector('.modal_fade').classList.add('show');
					document.querySelector('.modal.chart').classList.add('show');
				}else{
					alert("Произошла ошибка: \n\n"+d.error);
				}
			}else{
				alert("Произошла ошибка: \n\n"+xhr.status+" ("+xhr.statusText+")");
			}
		};
		xhr.open('get','./get_charts_bus?id='+$busid);
		xhr.send();
	}
	function edit_bus($busid) { // Открытие модального окна для добавления\изменения рейсов и заполнение его при надобности
		var modal=document.querySelector('.modal.edit');
		closemodal(modal.querySelector('form'));
		if(Boolean($busid)){
			var xhr=new XMLHttpRequest();
			xhr.onload=function(){
				if(xhr.status===200){
					var d=JSON.parse(xhr.response);
					if(d.status===true){
						document.querySelector('.form-trans').value=d.bus.trans;
						document.querySelector('.form-price').value=d.bus.price;
						document.querySelector('.edit_id_hidden').value=$busid;
						d.bus_chart.forEach(function(elem) {
							let enweek=document.querySelector('.en_week_checkbox#'+elem.week_day),
								changeEvent=new Event('change'),
								controls=enweek.nextElementSibling.nextElementSibling;
							enweek.checked=true;
							enweek.dispatchEvent(changeEvent);
							controls.querySelector('.selstation').value=elem.sel_station;
							controls.querySelector('.seltime').value=elem.sel_time;
							controls.querySelector('.seltime').classList.add("timestamp_to_date");
							controls.querySelector('.seltime').nextElementSibling.nextElementSibling.value=elem.sel_time;
							controls.querySelector('.recstation').value=elem.rec_station;
							controls.querySelector('.rectime').value=elem.rec_time;
							controls.querySelector('.rectime').classList.add("timestamp_to_date");
							controls.querySelector('.rectime').nextElementSibling.nextElementSibling.value=elem.rec_time;
						});
						timestampsToDate();
						document.querySelector('.modal_fade').classList.add('show');
						document.querySelector('.modal.edit').classList.add('show');
					}else{
						alert("Произошла ошибка: \n\n"+d.error);
					}
				}else{
					alert("Произошла ошибка: \n\n"+xhr.status+" ("+xhr.statusText+")");
				}
			};
			xhr.open('get','./get_info_bus?id='+$busid); // Получение данных из БД
			xhr.send();
		}else{
			document.querySelector('.modal_fade').classList.add('show');
			document.querySelector('.modal.edit').classList.add('show');
		}
	}
	function closemodal(modal){ // закрытие модального окна
		modal.reset();
		modal.querySelectorAll('.control.chart input').forEach(function(elem) {
			elem.disabled=true;
		});
		document.querySelectorAll('.modal').forEach(function(elem) {
			elem.classList.remove('show');
		});
		document.querySelector('.modal_fade').classList.remove('show');
	}
	function copyChart(self){ // Копирование информации графика
		let controls=self.previousElementSibling,
			enweek=controls.previousElementSibling.previousElementSibling,
			out={};
		if(enweek.checked){
			out.enweek=true;
			out.selstation=controls.querySelector('.selstation').value;
			out.seltime=controls.querySelector('.seltime').value;
			out.recstation=controls.querySelector('.recstation').value;
			out.rectime=controls.querySelector('.rectime').value;
		}else{
			out.enweek=false;
		}
		sessionStorage.setItem("weeks_copy",JSON.stringify(out));
	}
	function pasteChart(self){ // Вставка информации графика
		let controls=self.previousElementSibling.previousElementSibling,
			enweek=controls.previousElementSibling.previousElementSibling,
			changeEvent=new Event('change'),
			copied=JSON.parse(sessionStorage.getItem("weeks_copy"));
		if(copied!==null){
			if(copied.enweek){
				enweek.checked=true;
				enweek.dispatchEvent(changeEvent);
				controls.querySelector('.selstation').value=copied.selstation;
				controls.querySelector('.seltime').value=copied.seltime;
				controls.querySelector('.seltime').dispatchEvent(changeEvent);
				controls.querySelector('.recstation').value=copied.recstation;
				controls.querySelector('.rectime').value=copied.rectime;
				controls.querySelector('.rectime').dispatchEvent(changeEvent);
			}else{
				enweek.checked=null;
				enweek.dispatchEvent(changeEvent);
			}
		}else{
			alert("Нечего вставлять   ┐(`～` )┌");
		}
	}
</script>
<script src="js/timestamp_to_date.js"></script>