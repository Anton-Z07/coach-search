<?php

class TrainingsController extends CAdminController
{
	public function init()
	{
		$this->title = 'Тренинги';
		$this->breadcrumbs[] = array('url' => '/admin/trainings', 'name' => $this->title);
	}

	public function actionIndex($id=false)
	{
		$this->render('index');
	}

	public function actionEdit($id=false)
	{
		$this->title = 'Управление тренингом';
		$this->breadcrumbs[] = ['name' => $this->title];

		if ($id)
		{
			$training = Training::findById($id);
		}
		else
		{
			$training = new Training;
		}
		if (Yii::app()->request->isPostRequest)
		{
			$training->attributes = $_POST['training'];
			if ($training->save())
			{	
				$this->redirect('/admin/trainings');
			}
		}

		$this->render('edit', ['training'=>$training]);
	}

	public function actionAjax()
	{
		$criteria = new CDbCriteria();
		list($trainings, $n, $count) = DatatableHelper::GetRecords('Training', [], false, $criteria);

		$res = [];
		foreach ($trainings as $training)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $training->id;
			$tmp['name'] = $training->name;
			$tmp['coach'] = $training->coach->name;
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionDelete($id)
	{
		Training::model()->deleteByPk($id);
	}
}