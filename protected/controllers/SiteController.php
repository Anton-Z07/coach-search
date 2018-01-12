<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		//var_dump(CPasswordHelper::hashPassword('', 11));
		if (!Yii::app()->user->isGuest)
			$this->redirect('/site/redirect');

		$message = '';
		if (Yii::app()->request->isPostRequest)
		{
			$login = Yii::app()->request->getParam('login');
			$password = Yii::app()->request->getParam('password');

			if ($login && $password)
			{
				$user = new UserIdentity($login, $password);
				if ($user->authenticate())
				{
					Yii::app()->user->login($user, 3600*24*7);
					$this->redirect('/site/redirect');
				}
				else
					$message = 'Неправильный логин или пароль';
			}
			else
				$message = 'Заполнены не все поля';
		}
		$this->renderPartial('index', ['message' => $message]);
	}

	public function actionRedirect()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect('/');
		if (Yii::app()->user->type == 'admin')
			$this->redirect('/admin');
		if (Yii::app()->user->type == 'client')
			$this->redirect('/client');
		if (Yii::app()->user->type == 'coach')
			$this->redirect('/coach');
		$this->redirect('/site/logout');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest || 1)
				//echo $error['message'];
				var_dump($error);
			else
				$this->render('error', $error);
		}
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('/');
	}
}