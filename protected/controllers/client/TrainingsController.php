<?php

class TrainingsController extends CClientController
{
	public function init()
	{
		$this->title = 'Тренинги';
		$this->breadcrumbs[] = array('url' => '/client/trainings', 'name' => $this->title);
	}

	public function actionIndex()
	{
		$trainings = Training::findMany([]);
		$this->render('index', ['trainings'=>$trainings]);
	}

	public function actionView($id)
	{
		$training = Training::findById($id);
		if (!$training) die();

		$this->render('view', ['training'=>$training]);
	}

	public function actionBuy($id)
	{
		$package = TrainingPackage::findById($id);
		if (!$package) die();
		$this->render('buy', ['package'=>$package]);
	}

	public function actionPaid($id)
	{
		$package = TrainingPackage::findById($id);
		if (!$package) die();
		$good = U::user()->buy($package);
		if ($good)
			$this->redirect('/client/trainings/TrainingBought/' . $good->id);
	}

	public function actionTrainingBought($id)
	{
		$client_training = ClientTraining::findById($id);
		if (!$client_training) die();
		$this->render('training_bought', ['training'=>$client_training->training]);
	}

	public function actionMy()
	{
		$records = ClientTraining::findMany();
		$this->render('my', ['records'=>$records]);
	}
}