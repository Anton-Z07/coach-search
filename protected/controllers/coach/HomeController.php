<?php

class HomeController extends CCoachController
{
	public function actionIndex()
	{
		$this->redirect(Yii::app()->params['coachStartPage']);
	}
}