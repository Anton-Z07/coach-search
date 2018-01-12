<?php

class Coach extends ActiveRecord
{
	protected static $dates = ['birthdate'];

	public function tableName()
	{
		return 'coach';
	}

	public function rules()
	{
		return array(
			array('login, password, uid', 'required'),
			array('deleted', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			array('login, password, city, email, education, experience', 'length', 'max'=>100),
			array('uid', 'length', 'max'=>20),
			array('photo, last_name, first_name, middle_name, phone', 'length', 'max'=>50),
			array('birthdate', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'trainings'=>array(self::HAS_MANY, 'Training', 'id_coach'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPhoto()
	{
		return $this->photo ? "/uploads/profiles/coach_" . $this->id . '/' . $this->photo : "/images/avatar.png";
	}

	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
}
