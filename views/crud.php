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
		<?if(count($buses)>0)foreach($buses as $key=>$bus):?>
		<tr class="bus_item">
			<td><?=$bus['id']?></td>
			<td><?=$bus['price']?> тг.</td>
			<td><?=$bus['trans']?></td>
			<td>
				<a href="#" onclick="open_chart(<?=$bus['id']?>)">График поездок</a><br>
				<a href="#" onclick="edit_bus(<?=$bus['id']?>)">Изменить</a><br>
				<a href="/delete_bus?id=<?=$bus['id']?>">Удалить</a><br>
			</td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>
<div class="modal_fade" onclick="closemodal(document.querySelector('.modal.edit form'))"></div>
<div class="modal chart">
	<div class="control">
		
	</div>
</div>
<div class="modal edit">
	<form action="/save_bus" method=post>
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
		<div class="control">
			<input type="checkbox" id="mon" value="mon" name="en_week[0]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="mon">Понедельник</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[mon]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[mon]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[mon]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[mon]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="tue" value="tue" name="en_week[1]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="tue">Вторник</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[tue]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[tue]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[tue]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[tue]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="wed" value="wed" name="en_week[2]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="wed">Среда</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[wed]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[wed]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[wed]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[wed]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="thu" value="thu" name="en_week[3]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="thu">Четверг</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[thu]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[thu]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[thu]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[thu]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="fri" value="fri" name="en_week[4]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="fri">Пятница</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[fri]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[fri]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[fri]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[fri]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="sat" value="sat" name="en_week[5]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="sat">Суббота</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[sat]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[sat]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[sat]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[sat]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
		<div class="control">
			<input type="checkbox" id="sun" value="sun" name="en_week[6]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="sun">Воскресенье</label>
			<div class="control chart">
				Пункт отправления: <input class="selstation" required="" disabled="" type="text" name="week_selstation[sun]"><br>
				Время отправления: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker seltime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[sun]">
				Пункт прибытия: <input class="recstation" required="" disabled="" type="text" name="week_recstation[sun]"><br>
				Время прибытия: <input data-ttd_action="%hou%:%min%" required="" disabled="" type="text" readonly="" class="timepicker rectime" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[sun]">
			</div>
			<button type=button class="copy" onclick="copyChart(this);">Копировать</button>
			<button type=button class="paste" onclick="pasteChart(this);">Вставить</button>
		</div>
		<hr>
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
	$('.timepicker').datetimepicker({
		format:"H:i",
		step:5,
		datepicker:false,
	});
	function convertToTs(self){
		let temp=new Date(),
			hours_mins=self.value.split(":");
		temp.setTime(0);
		temp.setMinutes(hours_mins[1]);
		temp.setHours(hours_mins[0]);
		self.nextElementSibling.nextElementSibling.value=temp.getTime()/1000;
	}
	function enable_week_control(self){
		let controls=self.nextElementSibling.nextElementSibling;
		controls.querySelectorAll('input').forEach(function(elem) {
			elem.disabled=self.checked?null:true;
			elem.value="";
		});
	}
	function open_chart($busid){
		document.querySelector('.modal_fade').classList.add('show');
		document.querySelector('.modal.chart').classList.add('show');
	}
	function edit_bus($busid) {
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
			xhr.open('get','/get_info_bus?id='+$busid); // Получение данных из БД
			xhr.send();
		}else{
			document.querySelector('.modal_fade').classList.add('show');
			document.querySelector('.modal.edit').classList.add('show');
		}
	}
	function closemodal(modal){
		modal.reset();
		modal.querySelectorAll('.control.chart input').forEach(function(elem) {
			elem.disabled=true;
		});
		document.querySelectorAll('.modal').forEach(function(elem) {
			elem.classList.remove('show');
		});
		document.querySelector('.modal_fade').classList.remove('show');
	}
	function copyChart(self){ // Копирования информации графика
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