<?php

class ProfileController extends CCoachController
{
	public function init()
	{
		$this->title = 'Профиль';
		$this->breadcrumbs[] = array('url' => '/coach/profile', 'name' => $this->title);
	}

	public function actionIndex()
	{
		$this->render('index', []);
	}

	public function actionEdit()
	{
		$coach = U::user();
		if (Yii::app()->request->isPostRequest)
		{
			$pass = $coach->password;
			$coach->password = '';
			$coach->attributes = $_POST['coach'];
			if ($coach->password)
				$coach->password = U::hash($coach->password);
			else
				$coach->password = $pass;
			if ($coach->save())
			{	
				$this->redirect('/coach/profile/edit');
			}
		}
		$this->render('edit', ['coach'=>$coach]);
	}
}