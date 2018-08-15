function timestampsToDate() {
		function toZero(n) {
			if (n < 10) return "0" + n;
			else return n;
		}

		function toMonth(n) {
			var months = ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"];
			return months[n];
		}
		var tstamps = document.querySelectorAll('.timestamp_to_date');
		for (var i = 0; i < tstamps.length; i++) {
			var d = new Date(),
				format = tstamps[i].getAttribute('data-ttd_action'),
				innerf="innerText";
			if(tstamps[i].tagName=='INPUT'){
				innerf='value';
			}
			d.setTime(tstamps[i][innerf] * 1000);
			if (Boolean(format)) {
				if(tstamps[i].getAttribute("data-tdd_utc")===null){
					tstamps[i][innerf] = format
						.replace(/%d%/g, toZero(d.getDate()))
						.replace(/%m%/g, toMonth(d.getMonth()))
						.replace(/%y%/g, d.getFullYear())
						.replace(/%hou%/g, toZero(d.getHours()))
						.replace(/%min%/g, toZero(d.getMinutes()))
						.replace(/%sec%/g, toZero(d.getSeconds()))
						.replace(/%M%/g, toZero(d.getMonth() + 1));
				}else{
					tstamps[i][innerf] = format
						.replace(/%d%/g, toZero(d.getUTCDate()))
						.replace(/%m%/g, toMonth(d.getUTCMonth()))
						.replace(/%y%/g, d.getUTCFullYear())
						.replace(/%hou%/g, toZero(d.getUTCHours()))
						.replace(/%min%/g, toZero(d.getUTCMinutes()))
						.replace(/%sec%/g, toZero(d.getUTCSeconds()))
						.replace(/%M%/g, toZero(d.getUTCMonth() + 1));
				}
			} else
				tstamps[i][innerf] = toZero(d.getDate()) + " " + toMonth(d.getMonth()) + " " + d.getFullYear();
			tstamps[i].classList.remove("timestamp_to_date");
		}
	}