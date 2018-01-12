<div class="col-md-6">
	<form method="POST" class="form-horizontal">
		<div class="panel panel-flat">

			<div class="panel-body">
								<div class="col-md-11">
									<div class="form-group">
										<label class="col-sm-3 control-label text-right">Имя:</label>
										<div class="col-sm-9">
											<input type="text" name="client[name]" class="form-control" value="<?= $client->name ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label text-right">Логин:</label>
										<div class="col-sm-9">
											<input type="text" name="client[login]" class="form-control" value="<?= $client->login ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label text-right">Пароль:</label>
										<div class="col-sm-9">
											<input type="text" name="client[password]" class="form-control" placeholder="Пустое поле - не менять пароль">
										</div>
									</div>
								</div>

						<div class="text-right">
							<a href="/admin/clients" class="btn btn-default">Отмена</a>&nbsp;
							<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					</div>
			</div>
		</div>
	</form>
</div>