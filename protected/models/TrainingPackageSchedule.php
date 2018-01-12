<?php

class TrainingPackageSchedule extends ActiveRecord
{
	public function tableName()
	{
		return 'training_package_schedule';
	}

	public function rules()
	{
		return array(
			array('id_training_package, start_date', 'required'),
			array('id_training_package, id_training_interval', 'numerical', 'integerOnly'=>true),
			array('end_date', 'safe'),
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

	public static function addDate($day, $id_training, $id_package)
	{
		$item = new self;
		$item->id_training = $id_training;
		$item->id_training_package = $id_package;
		$item->start_date = U::td($day->date . ' ' . $day->from);
		$item->end_date = U::td($day->date . ' ' . $day->to);
		$item->save();
	}

	public function getTimeInterval()
	{
		$day_start = date('d.m.Y', strtotime($this->start_date));
		$time_start = date('H:i', strtotime($this->start_date));
		$time_end = date('H:i', strtotime($this->end_date));
		return $day_start . ' с ' . $time_start . ' до ' . $time_end;
	}	
}
