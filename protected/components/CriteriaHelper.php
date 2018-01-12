<?php

class CriteriaHelper
{
	public static function SetDaterange($criteria)
	{
		list($from, $to) = Filter::Daterange();
		$criteria->addCondition("t.create_date>='$from' AND t.create_date<='$to'");
	}

	public static function SetFilter($criteria, $field)
	{
		$val = Filter::GetVal($field);
		if ($val)
			$criteria->compare($field, $val);
	}
}