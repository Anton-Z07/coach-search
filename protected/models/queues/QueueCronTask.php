<?php

class QueueCronTask extends QueuePrototype
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'queue_cron_task';
	}
}