<?php

class CoachesController extends CClientController
{
	public function init()
	{
		$this->title = 'Тренеры';
		$this->breadcrumbs[] = array('url' => '/client/coaches', 'name' => $this->title);
	}

	public function actionIndex()
	{
		$coaches = Coach::findMany([]);
		$this->render('index', ['coaches'=>$coaches]);
	}

	public function actionView($id)
	{
		$coach = Coach::findById($id);
		if (!$coach) die();

		$this->render('view', ['coach'=>$coach]);
	}
}