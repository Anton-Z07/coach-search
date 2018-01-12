<div class="row">
	<div class="col-3 mr-1">
		<img class="col-img" src="<?= $training->getImage(); ?>" />
	</div>
	<div class="col-8">
		<h3><?= $training->name; ?></h3>
		<p>
			Количество участников: 666 <br />
			Осталось мест: 555 <br />
			Тип тренинга: <?= $training->type->name; ?>
		</p>
	</div>
</div>

<p>
	<div>
		<? foreach ($training->packages as $package): ?>
			<div class="row align-items-center mb-2">
				<div class="col-md-7 text-right"><?=$package->getName(); ?></div>
				<div class="col-md-1"></div>
				<div class="col-md-4">
					<? if (U::user()->isSingedForPackage($package->id)): ?>
						<i class="fa fa-check-circle text-success"></i> Вы записаны
					<? else: ?>
						<a href="/client/trainings/buy/<?=$package->id;?>" class="btn btn-primary btn-sm"><?=$package->price; ?> руб.</a>

					<? endif; ?>
				</div>
			</div>
		<? endforeach; ?>
	</div>
</p>
<p>
	<?= $training->description ;?>
</p>
<p>
	Результат: <?= $training->result ;?>
</p>
<p>
	<?=$training->getWayToMetroIcon();?> <?= $training->minutes_to_metro; ?> мин. до <img class="metro-logo" src="/images/moscow-metro.png" /><?=$training->merto_station; ?>
</p>
<p>
	Тренер: <a href="/client/coaches/view/<?=$training->id_coach;?>"><?= $training->coach->getName(); ?></a>
</p>