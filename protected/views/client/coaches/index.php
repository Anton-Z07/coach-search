<div class="coach-training-list">
	<? foreach ($trainings as $training): ?>
		<div class="training">
			<div class="media">
				<img class="d-flex mr-3" src="<?=$training->getImage();?>">
				<div class="media-body">
					<h5 class="mt-0"><a href="/client/trainings/view/<?=$training->id;?>"><?=$training->name;?></a></h5>
					<div>
						Блок цен
					</div>
					<?=$training->short_description;?>
					<div>
						Тренер: <?= $training->coach->getName(); ?>
					</div>
					<p>
						<?=$training->getWayToMetroIcon();?> <?= $training->minutes_to_metro; ?> мин. до <img class="metro-logo" src="/images/moscow-metro.png" /><?=$training->merto_station; ?>
					</p>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>