<?php

class Filter
{
	public static function Daterange($default=false)
	{
		$s = Yii::app()->request->getParam('f_daterange');
		$a = explode(' - ', $s);
		if (count($a) != 2)
		{
			if ($default && count($default) == 2)
				return $default;
			return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')];
		}
		return [date('Y-m-d 00:00:00', strtotime($a[0])), date('Y-m-d 23:59:59', strtotime($a[1]))];
	}

	public static function GetVal($field)
	{
		return Yii::app()->request->getParam('f_'. $field, '');
	}
}