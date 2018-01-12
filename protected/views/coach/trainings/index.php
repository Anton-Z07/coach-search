<div class="text-right">
	<a class="btn btn-primary" href="/coach/trainings/edit">Создать тренинг</a>
</div>

<br />

<div class="coach-training-list">
	<? foreach ($trainings as $training): ?>
		<div class="training">
			<div class="media">
				<img class=" d-flex mr-3" src="<?=$training->getImage();?>">
				<div class="media-body">
					<h5 class="mt-0"><a href="/coach/trainings/edit/<?=$training->id;?>"><?=$training->name;?></a></h5>
					<?=$training->short_description;?>
					<div>
						<small>Дата создания: <?=$training->ruDate('create_date');?></small>
					</div>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>