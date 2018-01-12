<div class="row">
	<div class="col-3 mr-1">
		<img class="col-img" src="<?= $coach->getPhoto(); ?>" />
	</div>
	<div class="col-8">
		<h3><?= $coach->last_name; ?></h3>
		<h3><?= $coach->first_name; ?></h3>
		<h3><?= $coach->middle_name; ?></h3>
		<br />
		<p>
			Образование: <?= $coach->education; ?> <br />
			Опыт: <?= $coach->experience; ?> <br />
		</p>
	</div>
</div>

<br /><br />

<h4>Тренинги</h4>
<div class="coach-training-list">
	<? foreach ($coach->trainings as $training): ?>
		<div class="training">
			<div class="media">
				<img class="d-flex mr-3" src="<?=$training->getImage();?>">
				<div class="media-body">
					<h5 class="mt-0"><a href="/client/trainings/view/<?=$training->id;?>"><?=$training->name;?></a></h5>
					<?= View::getPartial('_packages_short', ['training'=>$training, 'client'=>U::user()]); ?>
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

<br /><br />

<h4>Отзывы</h4>