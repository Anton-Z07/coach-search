<?php

class CoachesController extends CAdminController
{
	public function init()
	{
		$this->title = 'Тренеры';
		$this->breadcrumbs[] = array('url' => '/admin/coaches', 'name' => $this->title);
	}

	public function actionIndex($id=false)
	{
		$this->render('index');
	}

	public function actionEdit($id=false)
	{
		$this->title = 'Управление тренером';
		$this->breadcrumbs[] = ['name' => $this->title];

		if ($id)
		{
			$coach = Coach::findById($id);
		}
		else
		{
			$coach = new Coach;
		}
		if (Yii::app()->request->isPostRequest)
		{
			$pass = $coach->password;
			$coach->attributes = $_POST['coach'];
			if ($coach->password)
				$coach->password = CPasswordHelper::hashPassword($coach->password, 11);
			else
				$coach->password = $pass;

			if ($coach->save())
			{	
				$this->redirect('/admin/coaches');
			}
		}

		$this->render('edit', ['coach'=>$coach]);
	}

	public function actionAjax()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('deleted', 0);
		list($coaches, $n, $count) = DatatableHelper::GetRecords('Coach', [], false, $criteria);

		$res = [];
		foreach ($coaches as $coach)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $coach->id;
			$tmp['name'] = $coach->name;
			$tmp['login'] = $coach->login;
			$tmp['uid'] = $coach->uid;
			$tmp['balance'] = $coach->balance . ' руб';
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionDelete($id)
	{
		$coach = Coach::model()->findByPk($id);
		if ($coach)
		{
			$coach->deleted = 1;
			$coach->update('deleted');
		}
	}

	public function actionBalance()
	{
		$coach = Coach::findById($_POST['id_Coach']);
		if ($coach) {
			$diff = intval($_POST['balance']);
			$coach->balance += $diff;
			$coach->update('balance');
			$this->redirect('/admin/coaches');
		}
	}
}