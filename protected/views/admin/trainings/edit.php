<div class="col-md-6">
	<form method="POST" class="form-horizontal">
		<div class="panel panel-flat">

			<div class="panel-body">
								<div class="col-md-11">
									<div class="form-group">
										<label class="col-sm-3 control-label text-right">Название:</label>
										<div class="col-sm-9">
											<input type="text" name="training[name]" class="form-control" value="<?= $training->name ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label text-right">Тренер:</label>
										<div class="col-sm-9">
											<select name="training[id_coach]" class="form-control">
												<? Render::selectOptions('Coach'); ?>
											</select>
										</div>
									</div>
								</div>

						<div class="text-right">
							<a href="/admin/trainings" class="btn btn-default">Отмена</a>&nbsp;
							<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					</div>
			</div>

		</div>
	</form>
</div>