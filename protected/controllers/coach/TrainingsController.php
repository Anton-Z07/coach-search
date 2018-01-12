<?php

class TrainingsController extends CCoachController
{
	public function init()
	{
		$this->title = 'Тренинги';
		$this->breadcrumbs[] = array('url' => '/coach/trainings', 'name' => $this->title);
	}

	public function actionIndex()
	{
		$trainings = Training::findMany(['id_coach'=>U::id()]);
		$this->render('index', ['trainings'=>$trainings]);
	}

	public function actionEdit($id=false)
	{
		if ($id) {
			$training = Training::findById($id);
			if (!$training || $training->id_coach != U::id()) die();
		}
		else {
			$training = new Training;
			$training->id_coach = U::id();
		}

		if (Yii::app()->request->isPostRequest)
		{
			$training->attributes = $_POST['training'];

			$packages = TrainingPackage::findMany(['id_training'=>$id]);
			$ids = [];
			if ($_POST['package']['id']) {
				foreach ($_POST['package']['id'] as $i => $pack_id) {
					if ($pack_id) $ids[] = $pack_id;
					else {
						$package = new TrainingPackage;
						$package->id_training = $id;
						$package->name = $_POST['package']['name'][$i];
						$package->description = $_POST['package']['description'][$i];
						$package->price = $_POST['package']['price'][$i];
						$package->save();
						$package->addSchedule( json_decode($_POST['package']['schedule'][$i]) );
					}
				}
			}
			foreach ($packages as $package)
				if (!in_array($package->id, $ids))
					$package->deletePackage();
				
			if ($training->save())
			{	
				$this->redirect('/coach/trainings');
			}
		}

		$packages = json_encode( $training->getPackagesArray() );
		$this->render('edit', ['training'=>$training, 'packages'=>$packages]);
	}

	public function actionDelete($id)
	{
		$training = Training::findById($id);
		if (!$training || $training->id_coach != U::id()) die();
		$training->delete();
		$this->redirect('/coach/trainings');
	}
}