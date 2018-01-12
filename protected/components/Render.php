<?php

class Render
{
	public static function selectOptions($class, $selected=null, $data_item=null, $field=null, $is_foo=false)
	{
		foreach ($class::model()->findAll() as $item)
		{
			echo "<option value='$item->id'".($selected==$item->id?"selected='selected'":'')." ".($data_item?"data-item='{$item->$data_item}'":'').">".($field?($is_foo?"{$item->$field()}":"{$item->$field}"):$item->name)."</option>";
		}
	}

	public static function selectOptionsFromArray($options, $selected=null)
	{
		foreach ($options as $val => $name)
			echo "<option value='$val'".($selected==$val?"selected='selected'":'').">$name</option>";
	}

	public static function selectOptionsFromObjArray($options, $name='name', $val='id', $selected=null)
	{
		foreach ($options as $opt)
			echo "<option value='{$opt->$val}'".($selected==$opt->$val?"selected='selected'":'').">{$opt->$name}</option>";
	}

	public static function cssIconForAction($action)
	{
		switch ($action) {
			case 'denied':
			case 'reservation_denied':
				return 'icon-cancel-circle2';
			case 'applied':
			case 'reservation_done':
			case 'paid':
				return 'icon-checkmark';
			case 'return':
				return 'fa fa-undo';
		}
		return 'default';
	}

	public static function textField($text)
	{
		echo str_replace("\n", '<br />', $text);
	}

	public static function hoursSelect($selected = false)
	{
		for ($i=0; $i<24; $i++)
			echo "<option ".($selected==$i?"selected='selected'":'').">".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>";
	}

	public static function minutesSelect($selected = false, $step = 5)
	{
		for ($i=0; $i<60 / $step; $i++)
		{
			$n = $i * $step;
			echo "<option ".($selected==$n?"selected='selected'":'').">".str_pad($n, 2, '0', STR_PAD_LEFT)."</option>";
		}
	}
}