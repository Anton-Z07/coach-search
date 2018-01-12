<script>
	function Add()
	{
		var i = $('#proto').clone();
		i.removeAttr('id');
		$('#tasks').append(i);
	}
</script>

<style>
	#proto {
		display: none;
	}
	.task {
		margin-bottom: 10px;
	}
</style>

<div class="panel panel-flat">
	<div class="panel-body">
		<div id="tasks">
			<? foreach (CronTask::findMany() as $t): ?>
				<div class="task">
					<form action="/admin/cron/save">
						<input type="hidden" name="id" value="<?=$t->id;?>">
						<input type="text" name="method" value="<?=$t->method;?>" class="method form-control w200" placeholder="Method" />
						<input type="text" name="minutes" value="<?=$t->minutes;?>" class="minutes form-control w100" placeholder="Minutes" />
						<input type="text" name="times" value="<?=$t->times;?>" class="times form-control w50" placeholder="Times" />
						
						<a href="/admin/cron/delete/<?=$t->id;?>" class="btn btn-danger fr"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						<button type="submit" class="btn btn-success fr">Сохранить</button>
					</form>
				</div>
			<? endforeach; ?>
		</div>
		<br />
		<a class="inner-link" onclick="Add();">Добавить</a>
	</div>
</div>

<div class="task" id="proto">
	<form action="/admin/cron/save">
		<input type="hidden" name="id" value="">
		<input type="text" name="method" value="" class="method form-control w200" placeholder="Method" />
		<input type="text" name="minutes" value="" class="minutes form-control w100" placeholder="Minutes" />
		<input type="text" name="times" value="" class="times form-control w50" placeholder="Times" />
		
		<button type="submit" class="btn btn-success fr">Сохранить</button>
	</form>
</div>
