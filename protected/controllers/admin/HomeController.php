<?php

class HomeController extends CAdminController
{
	public function actionIndex()
	{
		$this->redirect(Yii::app()->params['adminStartPage']);
	}
}