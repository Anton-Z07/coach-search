<?php

class CLock extends ActiveRecord
{
	public function tableName()
	{
		return 'c_lock';
	}

	public function rules()
	{
		return array(
			array('name, date', 'required'),
			array('name', 'length', 'max'=>200),
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

	public static function add($name)
	{
		$model = new self;
		$sql = "INSERT INTO ".$model->tableName()." ( name, date ) VALUES ('{$name}', NOW()) ON DUPLICATE KEY UPDATE date=NOW();";
		Yii::app()->db->createCommand($sql)->execute();
	}

	public static function check($name)
	{
		$item = self::findOne(['name'=>$name]);
		if (!$item || $item->date <  date('Y-m-d H:i:s', time()-60*5)) return false;
		return true;
	}

	public static function tryAdd($name)
	{
		if (self::check($name)) return false;
		self::add($name);
		return true;
	}

	public static function release($name)
	{
		self::model()->deleteByPk($name);
	}
}
