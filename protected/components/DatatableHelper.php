<?php

class DatatableHelper
{
	public static function GetRecordsWithMainParam($table, $main_param, $filter_fields=[], $all=false, $criteria=false)
	{
		if (gettype($main_param) != 'array')
			$main_param = [$main_param];
		foreach($main_param as $param)
			if (Filter::GetVal($param))
				return self::GetRecords($table, [$param], $all, $criteria);
		return self::GetRecords($table, $filter_fields, $all, $criteria);
	}
	
	public static function GetRecords($table, $filter_fields=[], $all=false, $criteria=false)
	{
		if (isset($_GET['start']) && $_GET['start'])
			$_GET['start'] = $_GET['start'] / 10 + 1;
		$length = (int)Yii::app()->request->getParam('length',10);

		if ($all)
		{
			$_GET['start'] = 1;
			$length = 9999999;
		}

		if ($criteria === false)
			$criteria = new CDbCriteria();
		DatatableHelper::SetCriteriaOrder($criteria, $table);
		if (in_array('daterange', $filter_fields))
			CriteriaHelper::SetDaterange($criteria);
		foreach ($filter_fields as $field)
			if ($field != 'daterange')
				CriteriaHelper::SetFilter($criteria, $field);
	    $count = $table::model()->count($criteria);
	    $pages = new CPagination($count);
	    $pages->pageVar = 'start';
	    $pages->pageSize = $length;
	    $pages->applyLimit($criteria);

	    $rs = $table::model()->findAll($criteria);
	    return [$rs, $pages->getOffset() + 1, $count];
	}

	public static function SetCriteriaOrder($criteria, $table)
	{
		//var_dump(self::GetOrder($table));
		if (($order = self::GetOrder($table)) && !($criteria->order && $order == 'id asc'))
		{
			$criteria->order = $order;
		}
	}

	public static function GetOrder($table)
	{
		if (!isset($_GET['order']) || !isset($_GET['order'][0])) return '';
		$col_n = $_GET['order'][0]['column'];
		$dir = $_GET['order'][0]['dir'];
		$name = $_GET['columns'][$col_n]['data'];
		if (in_array($name, array_keys($table::model()->attributes)) && in_array($dir, ['asc','desc']))
			return "$name $dir";
		return '';
	}
}