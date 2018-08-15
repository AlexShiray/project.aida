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
	.buses{
		width:100%;
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
			<td><?=$bus['price']?></td>
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
	
</div>
<div class="modal edit">
	<form action="/save_bus" method=post>
		<div class="control">
			Транспортер: <input type="text" name="trans">
		</div>
		<div class="control">
			Цена рейса: <input type="number" name="price" pattern="[\d]+">
		</div>
		<div class="control">
			<b>График поездок</b>
		</div>
		<div class="control">
			<input type="checkbox" id="mon" value="mon" name="en_week[0]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="mon">Понедельник</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[0]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[0]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[0]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[0]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="tue" value="tue" name="en_week[1]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="tue">Вторник</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[1]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[1]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[1]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[1]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="wed" value="wed" name="en_week[2]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="wed">Среда</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[2]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[2]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[2]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[2]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="thu" value="thu" name="en_week[3]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="thu">Четверг</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[3]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[3]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[3]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[3]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="fri" value="fri" name="en_week[4]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="fri">Пятница</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[4]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[4]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[4]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[4]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="sat" value="sat" name="en_week[5]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="sat">Суббота</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[5]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[5]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[5]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[5]">
			</div>
		</div>
		<div class="control">
			<input type="checkbox" id="sun" value="sun" name="en_week[6]" class="en_week_checkbox" onchange="enable_week_control(this)">
			<label for="sun">Воскресенье</label>
			<div class="control chart">
				Пункт отправления: <input disabled="" type="text" name="week_selstation[6]"><br>
				Время отправления <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_seltime[6]">
				Пункт прибытия: <input disabled="" type="text" name="week_recstation[6]"><br>
				Время прибытия <input disabled="" type="text" readonly="" class="timepicker" onchange="convertToTs(this)"><br>
				<input disabled="" type="hidden" name="week_rectime[6]">
			</div>
		</div>

		<div class="control">
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
		temp.setUTCMinutes(hours_mins[1]);
		temp.setUTCHours(hours_mins[0]);
		self.nextElementSibling.nextElementSibling.value=temp.getTime()/1000;
	}
	function enable_week_control(self){
		let controls=self.nextElementSibling.nextElementSibling;
		controls.querySelectorAll('input').forEach(function(elem) {
			elem.disabled=self.checked?null:true;
		});
	}
	function open_chart($busid){
		document.querySelector('.modal_fade').classList.add('show');
		document.querySelector('.modal.chart').classList.add('show');
	}
	function edit_bus($busid) {
		document.querySelector('.modal_fade').classList.add('show');
		document.querySelector('.modal.edit').classList.add('show');
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
</script>

<script src="js/timestamp_to_date.js"></script>