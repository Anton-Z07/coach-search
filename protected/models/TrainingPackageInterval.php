<?php

class TrainingPackageInterval extends ActiveRecord
{
	public function tableName()
	{
		return 'training_package_interval';
	}

	public function rules()
	{
		return array(
			array('id_training, id_training_package, start_date, end_date, days', 'required'),
			array('id_training, id_training_package', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function add($interval, $id_training, $id_package)
	{
		//var_dump($interval); die();
		$item = new self;
		$item->id_training = $id_training;
		$item->id_training_package = $id_package;
		$item->start_date = U::td($interval->date_from, false);
		$item->end_date = U::td($interval->date_to, false);
		$item->days = json_encode($interval->days);
		$item->save();
	}

	
}
