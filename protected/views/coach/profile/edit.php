<input type="file" id="photo-select" accept="image/png,image/jpeg" data-type="profile" />

<form method="POST">
	<input type="hidden" name="coach[photo]" id="photo-input" value="<?=$coach->photo;?>">
	<div class="row">
		<div class="col-md-3">
			<div id="edit-photo">
				<img src="<?=$coach->getPhoto();?>">
				<div id="change-photo">
					<span class="helper"></span>
					<i class="fa fa-upload" aria-hidden="true"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Фамилия</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Иванов" name="coach[last_name]" value="<?=$coach->last_name;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Имя</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Пётр" name="coach[first_name]" value="<?=$coach->first_name;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Отчество</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Сергеевич" name="coach[middle_name]" value="<?=$coach->middle_name;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Дата рождения</label>
				<div class="col">
					<input type="date" class="form-control" name="coach[birthdate]" value="<?=$coach->birthdate;?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Город</label>
				<div class="col">
					<input type="text" class="form-control" placeholder="Москва" name="coach[city]" value="<?=$coach->city;?>">
				</div>
			</div>
		</div>
	</div>

	<div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Email</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="example@example.com" name="coach[email]" value="<?=$coach->email;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Телефон</label>
			<div class="col">
				<input type="text" class="form-control mask" mask="8(999)999-99-99" placeholder="8(900)123-45-67" name="coach[phone]" value="<?=$coach->phone;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Образование</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="МГТУ им. Баумана" name="coach[education]" value="<?=$coach->education;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Опыт</label>
			<div class="col">
				<input type="text" class="form-control" placeholder="3 года" name="coach[experience]" value="<?=$coach->experience;?>">
			</div>
		</div>
	</div>

	<div class="text-right">
		<a href="/coach" class="btn btn-secondary">Отмена</a>
		<button type="submit" class="btn btn-success">Сохранить</button>
	</div>
</form>