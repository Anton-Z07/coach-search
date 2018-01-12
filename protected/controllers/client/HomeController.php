<?php

class HomeController extends CClientController
{
	public function actionIndex()
	{
		$this->redirect(Yii::app()->params['clientStartPage']);
	}
}