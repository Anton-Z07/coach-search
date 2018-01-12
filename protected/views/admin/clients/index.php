<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/admin/clients/ajax",
			},
			columns: [
		        { data: 'n' },
		        { data: 'id' },
		        { data: 'name' },
		        { data: 'login' },
		        { data: 'balance' },
		        { data: 'id' },
		    ],
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		    	{ targets: 5, orderable: false, 
		    		render: function ( data, type, row ) {
		    			var balance = '<a class="text-success-600" onclick="Balance(\''+row.balance+'\', '+row.id+');" data-toggle="modal" data-target="#modal_balance" title="Пополнить баланс"><i class=" icon-cash4"></i></a>';
		    			var edit = '<a class="text-primary-600" href="/admin/clients/edit/'+data+'" title="Редактировать"><i class="icon-pencil7"></i></a>';
		    			var del = '<a class="text-danger-600" onclick="ConfirmDelete('+data+');" title="Удалить"><i class="icon-trash"></i></a>';
                    	return edit  + balance +  del;
                	}
            	},
		   	]
		});
	});

	function ConfirmDelete(id)
	{
		if (confirm('Точно удалить клиента?'))
			Delete(id);
	}

	function Delete(id)
	{
		$.get('/admin/clients/delete/'+id, function(){
			table.ajax.reload();
		});
	}

	function Balance(current, id_client)
	{
		$('#cur_balance').text(current);
		$('#balance_id_user').val(id_client);
	}
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<a type="button" class="btn btn-success" style="float: right" href="/admin/clients/edit" id="excel_button">Добавить клиента</a>
		</div>
	</div>
	<table class="table datatable-ajax">
		<thead>
			<tr>
				<th>#</th>
				<th>ID</th>
				<th>Имя</th>
				<th>Логин</th>
				<th>Баланс</th>
				<th>Действия</th>
			</tr>
		</thead>
	</table>
</div>

<div id="modal_balance" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Пополнить баланс</h5>
			</div>
			<form method="POST" class="form-horizontal" action="/admin/clients/balance">
				<div class="modal-body">
					<div>Текущий баланс: <span id="cur_balance"></span></div>
					<input type="hidden" name="id_client" id="balance_id_user" />
					<br />
					<div class="form-group">
						<label class="col-sm-3 control-label">Пополнить на</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="balance" placeholder="10000">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
					<button type="submit" class="btn btn-primary">Пополнить</button>
				</div>
		</div>
	</div>
</div>