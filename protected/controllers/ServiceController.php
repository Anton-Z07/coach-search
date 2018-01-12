<?php

class ServiceController extends Controller
{
	public function actionGetSmsLink($code)
	{
		$item = SmsShortLink::model()->findByPk($code);
		if ($item) {
			$item->click();
			echo $item->link;
		}
	}
}