<div class="panel panel-flat x-scroll">
	<div class="panel-body">
		<div class="panel-heading">
		<form class="row form-inline">
			<div class="col-daterange">
				<div class="input-group">
					<span class="input-group-addon"><i class="icon-calendar22"></i></span>
					<input type="text" class="form-control daterange-basic" value="<?=Filter::GetVal('daterange');?>" readonly="readonly" name="f_daterange"> 
				</div>
			</div>
			<button type="submit" class="btn btn-primary" onclick="$('.datatable-ajax').DataTable().ajax.reload();">Применить</button>
		</form>
	</div>
		<table class="table">
			<thead>
				<tr>
					<th>Клиент</th>
					<th>Всего СМС</th>
					<th>В ожидании</th>
					<th>Ошибка отправки</th>
					<th>Отправлено</th>
					<th>Уникальные Клики</th>
					<th>Клики</th>
					<th>Общая стоимость</th>
					<th>Cтоимость уник. клика</th>
				</tr>
			</thead>
			<tbody>
				<? foreach ($data as $id => $row): 
					echo $id == 'total' ? '<tfoot class="bg-slate-600">' : '<tr>';
				?>
						<td><?=$row['name'];?></td>
						<td><?=$row['total'];?></td>
						<td><?=$row['wait'];?> <span class="percentage"><?=Common::Percentage($row['wait'], $row['total']);?></span></td>
						<td><?=$row['sent'];?> <span class="percentage"><?=Common::Percentage($row['sent'], $row['total']);?></td>
						<td><?=$row['not_sent'];?> <span class="percentage"><?=Common::Percentage($row['not_sent'], $row['total']);?></td>
						<td><?=$row['unique_clicks'];?> <span class="percentage"><?=Common::Percentage($row['unique_clicks'], $row['sent']);?></td>
						<td><?=$row['clicks'];?> <span class="percentage"><?=Common::Percentage($row['clicks'], $row['unique_clicks']);?></td>
						<td><?=$row['cost'];?> <?=$row['cost'] ? 'руб' : '';?></td>
						<td><?=$row['unique_click_cost'];?></td></td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	</div>
</div>