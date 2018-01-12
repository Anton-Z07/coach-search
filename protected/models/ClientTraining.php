<?php

class ClientTraining extends ActiveRecord
{
	public function tableName()
	{
		return 'client_training';
	}

	public function rules()
	{
		return array(
			array('id_training, id_training_package, id_coach, id_client, cost', 'required'),
			array('id_training, id_training_package, id_coach, id_client, cost', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'training'=>array(self::BELONGS_TO, 'Training', 'id_training'),
			'package'=>array(self::BELONGS_TO, 'TrainingPackage', 'id_training_package'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
