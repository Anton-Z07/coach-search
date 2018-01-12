<?php

class Training extends ActiveRecord
{
	public function tableName()
	{
		return 'training';
	}

	public function rules()
    {
        return array(
            array('name, id_coach, field, theme, short_description, id_type, result, description', 'required'),
            array('id_coach, id_type, minutes_to_metro', 'numerical', 'integerOnly'=>true),
            array('name, theme, short_description', 'length', 'max'=>200),
            array('field', 'length', 'max'=>100),
            array('image, merto_station', 'length', 'max'=>50),
            array('way_to_metro', 'length', 'max'=>10),
            array('address', 'safe'),
        );
    }

	public function relations()
	{
		return array(
			'coach'=>array(self::BELONGS_TO, 'Coach', 'id_coach'),
			'type'=>array(self::BELONGS_TO, 'TrainingType', 'id_type'),
			'packages'=>array(self::HAS_MANY, 'TrainingPackage', 'id_training'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getImage()
	{
		return $this->image ? "/uploads/trainings/coach_" . $this->id_coach . '/' . $this->image : "/images/training.png";
	}

	public static function getWaysToMetro()
	{
		return ['transport'=>'Общественным транспортом', 'on_foot'=>'Пешком'];
	}

	public function getWayToMetroIcon()
	{
		$arr = ['on_foot'=>'<i class="fa fa-male"></i>',
			'transport'=>'<i class="fa fa-bus"></i>'];
		return isset($arr[$this->way_to_metro]) ? $arr[$this->way_to_metro] : '';
	}

	public function getPackagesArray()
	{
		$res = [];
		foreach ($this->packages as $pack) {
			$arr = $pack->attributes;
			$arr['days'] = $pack->getSingleDays();
			$arr['intervals'] = $pack->getIntervals();
			$res[] = $arr;
		}
		return $res;
	}
}
