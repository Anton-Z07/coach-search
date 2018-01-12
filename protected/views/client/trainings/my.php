<div class="coach-training-list">
	<? foreach ($records as $record): 
	$training = $record->training;
	?>
		<div class="training">
			<div class="media">
				<img class="d-flex mr-3" src="<?=$training->getImage();?>">
				<div class="media-body">
					<h5 class="mt-0"><a href="/client/trainings/view/<?=$training->id;?>"><?=$training->name;?></a></h5>
					<div>
						Тренер: <a href="/client/coaches/view/<?=$training->id_coach;?>"><?= $training->coach->getName(); ?></a>
					</div>
					<p>
						<span class="mr-5"><?=$training->address; ?></span>
						<?=$training->getWayToMetroIcon();?> <?= $training->minutes_to_metro; ?> мин. до <img class="metro-logo" src="/images/moscow-metro.png" /><?=$training->merto_station; ?>
					</p>
					<p>
						<? $first = true;
						foreach ($record->package->getFutureSchedule() as $day): ?>
							<div>
								<? if ($first): 
								$first = false; ?>
									<b><?=$day->getTimeInterval(); ?></b>
								<? else: ?>
									<?=$day->getTimeInterval(); ?>
								<? endif; ?>
							</div>
						<? endforeach; ?>
					</p>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>