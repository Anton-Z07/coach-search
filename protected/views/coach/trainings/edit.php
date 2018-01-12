<script>
	var curAddDateBtn;
	var packages;

	$(function(){
		packages = JSON.parse('<?=$packages; ?>');
		if (packages.length)
			for(i in packages)
				AddExistingPackage(packages[i]);
		else
			AddPackage();
		l(packages);

		$('#addDateModal,#addIntervalModal').on('show.bs.modal', function (event) {
			curAddDateBtn = $(event.relatedTarget).closest("td").find('.add_dates');
			if ($(event.relatedTarget).data('date'))
				ConfigureAddDateModal(event.relatedTarget);
			else
				$('#add-date-modal-mode').val( 'new' );
			if ($(event.relatedTarget).data('days'))
				ConfigureAddIntervalModal(event.relatedTarget);
			else
				$('#add-interval-modal-mode').val( 'new' );
		});
		
		$('#daterange-from').datepicker().on('changeDate', function(){
			var d = moment($(this).datepicker('getDate')).format('DD.MM.YYYY');
			$('#daterange-to').datepicker('setStartDate', d);
			OnDaterangeChange();
		});
		$('#daterange-to').datepicker().on('changeDate', function(){
			OnDaterangeChange();
		});
		UpdateTimeInputs();
	});

	function AddDate()
	{
		if ($("#add-date-modal-date").val()) {
			$('#addDateModal').modal("hide");
			var from = $("#add-date-modal-hours-from").val() + ":" + $("#add-date-modal-minutes-from").val();
			var to = $("#add-date-modal-hours-to").val() + ":" + $("#add-date-modal-minutes-to").val();
			var date = $("#add-date-modal-date").val();
			var index = -1;
			if ($('#add-date-modal-mode').val() == 'edit')
				index = $('#add-date-modal-edit-index').val()
			AddDateToPackage(curAddDateBtn, date, from, to, index);
		}
	}

	function AddDateToPackage(pack, date, from, to, index)
	{
		pack = pack.closest('tr');
		var date_str = date + " с " + from + " по " + to;
		date_str = "<div class='schedule_item'>" + date_str + "<i class='fa fa-pencil-square ml-2 text-info' data-toggle='modal' data-target='#addDateModal' data-date='"+date+"' data-from='"+from+"' data-to='"+to+"'></i> <i class='fa fa-minus-circle text-danger' onclick='RemoveScheduleItem(this);'></i></div>";
		InsertDateString(pack, date_str, index);
		AddScheduleItem(pack, {type:'date', date:date, from: from, to: to}, index);
	}

	function ConfigureAddDateModal(btn)
	{
		$('#add-date-modal-date').datepicker('setDate', $(btn).data('date'));
		$('#add-date-modal-hours-from').val( $(btn).data('from').split(':')[0] );
		$('#add-date-modal-minutes-from').val( $(btn).data('from').split(':')[1] );
		$('#add-date-modal-hours-to').val( $(btn).data('to').split(':')[0] );
		$('#add-date-modal-minutes-to').val( $(btn).data('to').split(':')[1] );
		var item = $(btn).closest('.schedule_item');
		$('#add-date-modal-mode').val( 'edit' );
		$('#add-date-modal-edit-index').val( item.index() );
		l('config');
	}

	function ConfigureAddIntervalModal(btn)
	{
		$('#daterange-from').datepicker('setDate', $(btn).data('from'));
		$('#daterange-to').datepicker('setDate', $(btn).data('to'));
		l($(btn).data('days')[0]);
		$('.form-check-input').prop('checked', false);
		for (i in $(btn).data('days')) {
			var d = $(btn).data('days')[i];
			$('.form-check-input[value='+d.day_eng+']').prop('checked', true);
		}
		UpdateTimeInputs();
		var item = $(btn).closest('.schedule_item');
		$('#add-interval-modal-mode').val( 'edit' );
		$('#add-interval-modal-edit-index').val( item.index() );
	}

	function AddExistingPackage(package)
	{
		var pack = AddPackage();
		$(pack).find('.pack_name').val(package.name);
		$(pack).find('.pack_description').val(package.description);
		$(pack).find('.pack_price').val(package.price);
		for (i in package.days) {
			var day = package.days[i];
			AddDateToPackage(pack, day.date, day.from_time, day.to_time, -1);
		}
		for (i in package.intervals) {
			var int = package.intervals[i];
			AddIntervalToPackage(pack, int.start_date, int.end_date, int.days, -1);
		}
	}

	function AddPackage()
	{
		var proto = $("#tr-proto").get(0).content.cloneNode(true);
		$('#tbl tbody').append(proto);
		if ($('#tbl tbody tr').size() > 1)
			$('#tbl .multirow.d-none').removeClass('d-none');
		else
			$('#tbl .multirow').addClass('d-none');
		return $('#tbl tbody tr').last();
	}

	function AddScheduleItem(package, obj, index)
	{
		var sch_input = package.closest('tr').find('.schedule');
		var schedule = JSON.parse(sch_input.val());
		if (index == -1)
			schedule.push(obj);
		else {
			schedule.splice(index, 1, obj);
		}
		sch_input.val( JSON.stringify(schedule) );
	}

	function UpdateTimeInputs()
	{
		$('.range-day').each(function(){
			if ($(this).find('.form-check-input').prop('checked'))
			{
				$(this).find('.time-inputs').removeClass('disabled');
				$(this).find('.time-inputs select').prop('disabled', false);
			}
			else {
				$(this).find('.time-inputs').addClass('disabled');
				$(this).find('.time-inputs select').prop('disabled', true);
			}
		});
	}

	function OnDaterangeChange()
	{
		var from = $("#daterange-from").datepicker('getDate');
		var to = $("#daterange-to").datepicker('getDate');
		if (!from || !to) return;
		ClearDayOfWeek();
		for (var m = moment(from); !m.isAfter(to); m.add(1, 'days')) {
			AddDayOfWeek(m.format('ddd'))
		}
	}

	function ClearDayOfWeek()
	{
		$('.range-day').each(function(){
			$(this).find('.day-count').data('count', 0);
			$(this).find('.day-count').text('');
		});
	}

	function AddDayOfWeek(day)
	{
		$('.range-day').each(function(){
			if ($(this).find('.form-check-input').attr('value') == day) {
				var c = 1 + $(this).find('.day-count').data('count');
				$(this).find('.day-count').data('count', c);
				$(this).find('.day-count').text(c + getWordForm(c, ' занятие', ' занятия', ' занятий'));
			}
			
		});
	}

	function AddInterval()
	{
		var from = $("#daterange-from").datepicker('getDate');
		var to = $("#daterange-to").datepicker('getDate');
		if (!from || !to) return;
		from = moment(from).format('DD.MM.YYYY');
		to = moment(to).format('DD.MM.YYYY');
		$('#addIntervalModal').modal("hide");
		days = [];
		
		$('.range-day').each(function(){
			if ($(this).find('.form-check-input').prop('checked')) {
				var from_t = $(this).find(".add-interval-modal-hours-from").val() + ":" + $(this).find(".add-interval-modal-minutes-from").val();
				var to_t = $(this).find(".add-interval-modal-hours-to").val() + ":" + $(this).find(".add-interval-modal-minutes-to").val();
				var c = $(this).find('.day-count').data('count');
				var day = $(this).find('.day-count').data('day');
				var day_of_week = $(this).find('.form-check-input').val();
				days.push({day: day, day_eng: day_of_week, from: from, to: to, count: c});
				
			}
			
		});
		var index = -1;
		if ($('#add-interval-modal-mode').val() == 'edit')
			index = $('#add-interval-modal-edit-index').val()
		AddIntervalToPackage(curAddDateBtn, from, to, days, index);
	}

	function AddIntervalToPackage(pack, from_date, to_date, days, index)
	{
		pack = pack.closest('tr');
		var sch_item = {type:'interval', date_from: from_date, date_to: to_date, days: []};
		date_str =  "<div class='schedule_item'>" + "С " + from_date + " по " + to_date + "<i class='fa fa-pencil-square ml-2 text-info' data-toggle='modal' data-target='#addIntervalModal' data-from='"+from_date+"' data-to='"+to_date+"' data-days='"+JSON.stringify(days)+"'></i> <i class='fa fa-minus-circle text-danger' onclick='RemoveScheduleItem(this);'></i>";
		days_str = '';
		for (i in days) {
			days_str += "<div>" + days[i].day  + " (" + days[i].count + getWordForm(days[i].count, ' занятие', ' занятия', ' занятий') + ")" + "</div>";
			sch_item.days.push({'from':days[i].from, to: days[i].to, day: days[i].day_eng});
		}

		date_str += '<div class="ml-3">' + days_str + "</div>" + "</div>";
		InsertDateString(pack, date_str, index);
		AddScheduleItem(pack, sch_item, index);
	}

	function InsertDateString(pack, date_str, index)
	{
		if (index == -1)
			pack.find('.add_dates').before(date_str);
		else {
			var old = pack.find('.schedule_item').eq(index);
			old.before(date_str);
			old.remove();
		}
	}

	function RemoveScheduleItem(btn)
	{
		var item = $(btn).closest('.schedule_item');
		var sch_input = item.closest('tr').find('.schedule');
		var schedule = JSON.parse(sch_input.val());
		schedule.splice(item.index(), 1);
		sch_input.val( JSON.stringify(schedule) );
		item.remove();
	}
</script>

<style>
	#tbl td {
		vertical-align: top;
	}
	.datepicker-inline {
		display: inline-block;
	}
	.disabled {
		opacity: 0.3;
	}
	.schedule_item i {
		display: none;
	}
	.schedule_item:hover i {
		display: inline-block;
	}
</style>

<input type="file" id="photo-select" accept="image/png,image/jpeg" data-type="training" />

<form method="POST">
	<input type="hidden" name="training[image]" id="photo-input" value="<?=$training->image;?>">
	<div class="row">
		<div class="col-md-3">
			<div id="edit-photo">
				<img src="<?=$training->getImage();?>">
				<div id="change-photo">
					<span class="helper"></span>
					<i class="fa fa-upload" aria-hidden="true"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Название</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Мастер-класс испанского языка" name="training[name]" value="<?=$training->name;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Область</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Языки" name="training[field]" value="<?=$training->field;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Тематика</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Испания" name="training[theme]" value="<?=$training->theme;?>">
				</div>
			</div>
		</div>
	</div>

	<div>
		<div>
			<h4>Пакеты услуг</h4>
			<table id="tbl" class="table">
				<thead>
					<tr>
						<th class="multirow">Название</th>
						<th class="multirow">Описание</th>
						<th>Расписание занятий</th>
						<th>Цена</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
			<div class="text-right">
				<button type="button" class="btn btn-primary" onclick="AddPackage();">Добавить пакет услуг</button>
			</div>
			<hr />
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Краткое описание</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="Краткое описание тренинга" name="training[short_description]" value="<?=$training->short_description;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Развёрнутое описание</label>
			<div class="col">
				<textarea class="form-control" placeholder="Развёрнутое описание тренинга" name="training[description]" rows="3"><?=$training->description;?></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Тип тренинга</label>
			<div class="col">
				<select class="form-control" name="training[id_type]">
					<? Render::selectOptions("TrainingType", $training->id_type); ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Адрес тренинга</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="Ул. Тверская, д. 6" name="training[address]" value="<?=$training->address;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Метро</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="Тверская" name="training[merto_station]" value="<?=$training->merto_station;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Сколько минут до метро</label>
			<div class="col">
				<div class="row">
					<div class="col-4">
						<input type="number" class="form-control" placeholder="15" name="training[minutes_to_metro]" value="<?=$training->minutes_to_metro;?>">
					</div>
					<div class="col-8">
						<select class="form-control" name="training[way_to_metro]">
							<? Render::selectOptionsFromArray(Training::getWaysToMetro(), $training->way_to_metro); ?>
						</select>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="text-right">
		<? if ($training->id): ?>
			<a href="/coach/trainings/delete/<?=$training->id;?>" class="btn btn-danger" style="float: left;">Удалить тренинг</a>
		<? endif; ?>
		<a href="/coach/trainings" class="btn btn-secondary">Отмена</a>
		<button type="submit" class="btn btn-success">Сохранить</button>
	</div>
</form>

<!-- Modal -->
<div class="modal fade" id="addDateModal" tabindex="-1" role="dialog" aria-hidden="true">
	<input type="hidden" id="add-date-modal-mode" value="new">
	<input type="hidden" id="add-date-modal-edit-index" value="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Добавить занятие</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>
					Дата занятия
					<input type="text" class="form-control datepicker datepicker-input start-today" placeholder="Дата" id="add-date-modal-date">
				</p>
					<p>
						Начало в
						<select class="form-control w80" id="add-date-modal-hours-from">
							<? Render::hoursSelect(17); ?>
						</select>
						<select class="form-control w80" id="add-date-modal-minutes-from">
							<? Render::minutesSelect(); ?>
						</select>
					</p><p>
						Окончание в
						<select class="form-control w80" id="add-date-modal-hours-to">
							<? Render::hoursSelect(20); ?>
						</select>
						<select class="form-control w80" id="add-date-modal-minutes-to">
							<? Render::minutesSelect(); ?>
						</select>
					</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary" onclick="AddDate();">Добавить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addIntervalModal" tabindex="-1" role="dialog" aria-hidden="true">
	<input type="hidden" id="add-interval-modal-mode" value="new">
	<input type="hidden" id="add-interval-modal-edit-index" value="">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Добавить интервал дат</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<h5>Дата начала</h5>
						<div class="datepicker start-today text-center" placeholder="Дата" id="daterange-from"></div>
					</div>
					<div class="col-md-6">
						<h5>Дата окончания</h5>
						<div class="datepicker start-today text-center" placeholder="Дата" id="daterange-to"></div>
					</div>
				</div>
				<hr />
				<div>
					<h5>Дни занятий</h5>
					<? foreach (Common::getDays() as $k => $day): ?>
						<div>
							<label class="range-day form-check-label">
								<input class="form-check-input" type="checkbox" value="<?= $k; ?>" onchange="UpdateTimeInputs();">
								<span class="w110"><?= $day; ?></span>
								<span class="time-inputs disabled">
									<span class="mr-3">
										<span class="mr-1">С</span>
										<select class="simple w60 add-interval-modal-hours-from">
											<? Render::hoursSelect(17); ?>
										</select>
										<select class="simple w60 add-interval-modal-minutes-from">
											<? Render::minutesSelect(); ?>
										</select>
									</span><span class="mr-5">
										<span class="mr-1">По</span>
										<select class="simple w60 add-interval-modal-hours-to">
											<? Render::hoursSelect(20); ?>
										</select>
										<select class="simple w60 add-interval-modal-minutes-to">
											<? Render::minutesSelect(); ?>
										</select>
									</span>
									<span class="day-count" data-count="0" data-day="<?= $day; ?>"></span>
								</span>
							</label>
						</div>
					<? endforeach; ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary" onclick="AddInterval();">Добавить</button>
			</div>
		</div>
	</div>
</div>

<template id="tr-proto">
	<tr>
		<td class="multirow">
			<input type="hidden" name="package[id][]" />
			<input type="hidden" name="package[schedule][]" class="schedule" value="[]" />
			<input type="text" class="form-control pack_name" placeholder="Стандарт" name="package[name][]" />
		</td>
		<td class="multirow">
			<textarea class="form-control pack_description" name="package[description][]"></textarea>
		</td>
		<td>
			<div>
				<p class="add_dates">
					<button type="button" class="btn btn-secondary btn-xs mr-1" data-toggle="modal" data-target="#addDateModal">Добавить дату</button>
					<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#addIntervalModal">Добавить интервал</button>
				</p>
			</div>
		</td>
		<td>
			<input type="number" class="form-control w100 pack_price" placeholder="3500" name="package[price][]"/>
		</td>
	</tr>
</template>