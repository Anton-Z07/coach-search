<?php

class ActiveRecord extends CActiveRecord
{
	protected static $dates = [];
	protected static $names = [];

	public function beforeSave() {
        $this->convertDates();
        return parent::beforeSave();
    }

    public function convertDates() {
    	foreach (static::$dates as $date)
        	if ($this->$date && $this->$date != '0000-00-00')
        		$this->$date = date('Y-m-d', strtotime($this->$date));
        	else
        		$this->$date = null;
    }

	public static function findOne($data=[])
	{
		if ((gettype($data) == 'object' && get_class($data) == 'CDbCriteria') || gettype($data) == 'string')
			return static::model()->find($data);
		if (gettype($data) == 'array')
			return static::model()->findByAttributes($data);
		if (gettype($data) == 'integer' || strval(intval($data)) === $data)
			return static::model()->findByPk($data);
	}

	public static function findMany($data=false)
	{
		if ($data === false)
			return static::model()->findAll();
		if ((gettype($data) == 'object' && get_class($data) == 'CDbCriteria') || gettype($data) == 'string')
			return static::model()->findAll($data);
		if (gettype($data) == 'array')
			return static::model()->findAllByAttributes($data);
	}

	public static function getAll($order=false)
	{
		$q = new CDbCriteria;
		if ($order!==false)
			$q->order = $order;
		return static::findMany($q);
	}

	public static function getNameById($id)
	{
		$child_obj = new static;
		$class_name = $child_obj->tableName();
		$arr_id = "$class_name.$id";
		if (isset(static::$names[$arr_id])) return static::$names[$arr_id];
		$name = FALSE;
		if (Yii::app()->params['cacheEnabled'])
			$name = Yii::app()->cache->get($class_name."::getNameById($id)");
		if ($name === FALSE)
		{
			$name = '';
			$model = static::findById($id);
			if ($model)
				$name = $model->getName();
			if (Yii::app()->params['cacheEnabled'])
				Yii::app()->cache->set(__CLASS__."::getNameById($id)", $name, 600);
		}
		static::$names[$arr_id] = $name;
		return $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function ruDate($field='date', $with_time=false)
	{
		$format = 'd.m.Y';
		if ($with_time) $format .= ' H:i';
		return date($format, strtotime($this->$field));
	}

	public static function findById($id)
	{
		return static::model()->findByPk($id);
	}
}