<?php

class QueueSms extends QueuePrototype
{
	public function tableName()
	{
		return 'queue_sms';
	}

	public function rules()
	{
		return array(
			array('worker_id, max_worker_num, pause', 'numerical', 'integerOnly'=>true),
			array('date_start, data', 'safe'),
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
}
