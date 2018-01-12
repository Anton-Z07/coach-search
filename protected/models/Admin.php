<?php

class Admin extends ActiveRecord
{
	public function tableName()
	{
		return 'admin';
	}

	public function rules()
	{
		return array(
			array('login, password, name', 'required'),
			array('login', 'length', 'max'=>20),
			array('password', 'length', 'max'=>100),
			array('name', 'length', 'max'=>50),
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
