<?php

class Client extends ActiveRecord
{
	public function tableName()
	{
		return 'client';
	}

	public function rules()
	{
		return array(
			array('login, password, name', 'required'),
			array('login, password, name', 'length', 'max'=>100),
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

	protected function afterConstruct()
	{
		$this->uid = substr(md5(time() . rand()), 0, 16);
		parent::afterConstruct();
	}

	public function buy($package)
	{
		$item = new ClientTraining;
		$item->id_client = U::id();
		$item->id_training = $package->id_training;
		$item->id_training_package = $package->id;
		$item->id_coach = $package->training->id_coach;
		$item->cost = $package->price;
		$item->save();
		return $item;
	}

	public function isSingedForPackage($id_package)
	{
		return ClientTraining::findOne(['id_training_package'=>$id_package, 'id_client'=>$this->id]) ? true : false;
	}
}
