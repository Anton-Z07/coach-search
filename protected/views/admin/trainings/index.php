<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/admin/trainings/ajax",
			},
			columns: [
		        { data: 'n' },
		        { data: 'id' },
		        { data: 'name' },
		        { data: 'coach' },
		        { data: 'id' },
		    ],
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		    	{ targets: 4, orderable: false, 
		    		render: function ( data, type, row ) {
		    			var edit = '<a class="text-primary-600" href="/admin/trainings/edit/'+data+'" title="Редактировать"><i class="icon-pencil7"></i></a>';
		    			var del = '<a class="text-danger-600" onclick="ConfirmDelete('+data+');" title="Удалить"><i class="icon-trash"></i></a>';
                    	return edit +  del;
                	}
            	},
		   	]
		});
	});

	function ConfirmDelete(id)
	{
		if (confirm('Точно удалить тренинг?'))
			Delete(id);
	}

	function Delete(id)
	{
		$.get('/admin/trainings/delete/'+id, function(){
			table.ajax.reload();
		});
	}
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<a type="button" class="btn btn-success" style="float: right" href="/admin/trainings/edit" id="excel_button">Добавить тренинг</a>
		</div>
	</div>
	<table class="table datatable-ajax">
		<thead>
			<tr>
				<th>#</th>
				<th>ID</th>
				<th>Имя</th>
				<th>Тренер</th>
				<th>Действия</th>
			</tr>
		</thead>
	</table>
</div>