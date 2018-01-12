<?php

class CronTask extends ActiveRecord
{
	public function tableName()
	{
		return 'cron_task';
	}

	public function rules()
	{
		return array(
			array('method, minutes', 'required'),
			array('minutes, times', 'numerical', 'integerOnly'=>true),
			array('method', 'length', 'max'=>100),
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

	public function isRightTime()
	{
		if (!$this->minutes) return false;

		return (round(time()/60) % $this->minutes) == 0 ? $this->times : 0;
	}
}
