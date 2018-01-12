<?php

class TrainingPackage extends ActiveRecord
{
	public function tableName()
	{
		return 'training_package';
	}

	public function rules()
	{
		return array(
			array('id_training, price', 'required'),
			array('id_training, price', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('description', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'schedule'=>array(self::HAS_MANY, 'TrainingPackageSchedule', 'id_training_package',
				'order'=>'start_date ASC',),
			'intervals'=>array(self::HAS_MANY, 'TrainingPackageInterval', 'id_training_package'),
			'training'=>array(self::BELONGS_TO, 'Training', 'id_training'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function deletePackage()
	{
		TrainingPackageSchedule::model()->deleteAllByAttributes( ['id_training_package'=>$this->id] );
		TrainingPackageInterval::model()->deleteAllByAttributes( ['id_training_package'=>$this->id] );
		$this->delete();
	}

	public function addSchedule($schedule)
	{
		foreach ($schedule as $item) {
			if ($item->type == 'date')
				TrainingPackageSchedule::addDate( $item, $this->id_training, $this->id );
			elseif ($item->type == 'interval')
				TrainingPackageInterval::add( $item, $this->id_training, $this->id );
		}
	}

	public function getSingleDays()
	{
		$days = [];
		foreach ($this->schedule as $day) {
			$d = [];
			$d['date'] = U::rd($day['start_date']);
			$d['from_time'] = date("H:i", strtotime($day['start_date']));
			$d['to_time'] = date("H:i", strtotime($day['end_date']));
			$days[] = $d;
		}
		return $days;
	}

	public function getIntervals()
	{
		$intervals = [];
		$days = Common::getDays();
		foreach ($this->intervals as $interval) {
			$int = [];
			$int['start_date'] = U::rd($interval->start_date);
			$int['end_date'] = U::rd($interval->end_date);
			$int['days'] = [];
			foreach (json_decode($interval->days, 1) as $day) {
				$day['count'] = Common::countDays($interval->start_date, $interval->end_date, $day['day']);
				$day['day_eng'] = $day['day'];
				$day['day'] = $days[ $day['day'] ];
				$int['days'][] = $day;
			}
			$intervals[] = $int;
		}
		return $intervals;
	}

	public function getName()
	{
		return $this->name ? $this->name : "Стандарт";
	}

	public function getFutureSchedule()
	{
		$schedule = [];
		$d = date('Y-m-d');
		foreach ($this->schedule() as $s)
			if ($s->start_date >= $d)
				$schedule[] = $s;
		return $schedule;
	}
}
