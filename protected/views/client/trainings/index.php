<div class="row">
	<div class="col-lg-4 order-lg-2 order-1">
		Меню
	</div>
	<div class="col-lg-8 order-lg-1 order-2">
		<div class="coach-training-list">
			<? foreach ($trainings as $training): ?>
				<div class="training">
					<div class="media">
						<img class="d-flex mr-3" src="<?=$training->getImage();?>">
						<div class="media-body">
							<h5 class="mt-0"><a href="/client/trainings/view/<?=$training->id;?>"><?=$training->name;?></a></h5>
							<?= View::getPartial('_packages_short', ['training'=>$training, 'client'=>U::user()]); ?>
							<?=$training->short_description;?>
							<div>
								Тренер: <a href="/client/coaches/view/<?=$training->id_coach;?>"><?= $training->coach->getName(); ?></a>
							</div>
							<p>
								<?=$training->getWayToMetroIcon();?> <?= $training->minutes_to_metro; ?> мин. до <img class="metro-logo" src="/images/moscow-metro.png" /><?=$training->merto_station; ?>
							</p>
						</div>
					</div>
				</div>
			<? endforeach; ?>
		</div>
	</div>
</div>