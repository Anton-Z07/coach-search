<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/admin/messages/ajax",
				data: function ( d ) {
	                d.f_daterange = $('#daterange').val();
	                d.f_id_client = $('#id_client').val();
	            }
			},
			columns: [
		        { data: 'n' },
		        { data: 'create_date' },
		        { data: 'client' },
		        { data: 'phone' },
		        { data: 'body' },
		        { data: 'status' },
		        { data: 'send_date' },
		        { data: 'cost' },
		        { data: 'unique_clicks' },
		        { data: 'clicks' },
		    ],
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		   	],
		   	"fnCreatedRow": function( tr, data ) {
		   		if (data.status_raw == 'sent')
		   			$(tr).find('td').eq(4).addClass('bg-success-400');
		   		if (data.status_raw == 'not_sent')
		   			$(tr).find('td').eq(4).addClass('bg-danger-400');
		   	}
		});
	});
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<form class="row form-inline" onsubmit="return false;">
			<div class="col-daterange">
				<div class="input-group">
					<span class="input-group-addon"><i class="icon-calendar22"></i></span>
					<input type="text" class="form-control daterange-basic" value="" readonly="readonly" id="daterange"> 
				</div>
			</div>
			<select class="form-control" id="id_client">
				<option value="">Все клиенты</option>
				<?= Render::selectOptions('Client'); ?>
			</select>
			<button type="submit" class="btn btn-primary" onclick="$('.datatable-ajax').DataTable().ajax.reload();">Применить</button>
		</form>
	</div>
	<div class="panel-body">
		<div>		
			<table class="table datatable-ajax">
				<thead>
					<tr>
						<th>#</th>
						<th>Дата создания</th>
						<th>Клиент</th>
						<th>Телефон</th>
						<th>Сообщение</th>
						<th>Статус</th>
						<th>Дата отправки</th>
						<th>Стоимость</th>
						<th>Уникальные клики</th>
						<th>Всего кликов</th>
					</tr>
				</thead>
			</table>

		</div>
	</div>
</div>