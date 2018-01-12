<?php

class QueuePrototype extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array(
			array('worker_id', 'numerical', 'integerOnly'=>true),
			array('date_create, date_start, data', 'safe'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function AddTask($data='')
	{
		$q = new static;
		$q->data = $data;
		return $q->save();
	}

	public static function AddDatedTask($data, $date)
	{
		$q = new static;
		$q->data = $data;
		$q->planned_date_start = $date;
		$q->save();
		var_dump($q->getErrors());
	}

	// Принимает массив строк
	public static function AddSeveralTasks($data_array)
	{
		$model = new static;
		$sql = "INSERT INTO ".$model->tableName()." ( data ) VALUES ";
		$values = "";
		foreach ($data_array as $data)
			$values .= ($values ? ',':'') . "( '$data' )";
		$sql .= $values;
		return Yii::app()->db->createCommand($sql)->execute();
	}

	public static function GetTableNames()
	{
		$sql = "SELECT TABLE_NAME 
			FROM INFORMATION_SCHEMA.TABLES
			WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='mfo' AND TABLE_NAME LIKE 'queue_%'";
		return Yii::app()->db->createCommand($sql)->queryColumn();
	}

	public static function GetModelNames()
	{
		$tables = self::GetTableNames();
		$res = [];
		foreach ($tables as $table)
		{
			$model = '';
			foreach (explode('_', $table) as $word)
				$model .= ucfirst($word);
			$res[] = $model;
		}
		return $res;
	}
}