<?php

class U
{
	public static function gp($name, $default=null)
	{
		return Yii::app()->request->getParam($name, $default);
	}

	public static function gi($name, $default=0)
	{
		$param = self::gp($name, false);
		return $param == false ? $default : intval($param);
	}

	public static function id()
	{
		return Yii::app()->user->innerId;
	}

	public static function type()
	{
		return Yii::app()->user->type;
	}

	public static function dt($time=false)
	{
		if (!$time) $time = time();
		return date('Y-m-d H:i:s', $time);
	}

	public static function td($date=false, $time=true)
	{
		if (!$date) $time = time();
		else $time = strtotime($date);
		$s = 'Y-m-d H:i:s';
		if (!$time) $s = 'Y-m-d';
		return date($s, $time);
	}

	public static function root()
	{
		return dirname(Yii::app()->request->scriptFile);
	}

	public static function rd($date, $time=false)
	{
		return Common::GetDateRu($date, $time);
	}

	public static function np($phone)
	{
		return Common::NormalizePhone($phone);
	}

	public static function user()
	{
		return Common::getUser();
	}

	public static function param($pamar)
	{
		return Yii::app()->params[$pamar];
	}

	public static function hash($str)
	{
		return CPasswordHelper::hashPassword($coach->password, 11);
	}
}