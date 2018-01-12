<div>
	<? foreach ($training->packages as $package): ?>
		<div class="row align-items-center mb-2">
			<div class="col-md-7 text-right"><?=$package->getName(); ?></div>
			<div class="col-md-1"></div>
			<div class="col-md-4">
				<? if ($client->isSingedForPackage($package->id)): ?>
					<i class="fa fa-check-circle text-success"></i> Вы записаны
				<? else: ?>
					<a href="/client/trainings/buy/<?=$package->id;?>" class="btn btn-primary btn-sm"><?=$package->price; ?> руб.</a>
				<? endif; ?>
			</div>
		</div>
	<? endforeach; ?>
</div>