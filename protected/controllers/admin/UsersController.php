<?php

class UsersController extends CAdminController
{
	public function init()
	{
		$this->title = 'Пользователи';
		$this->breadcrumbs[] = array('name' => $this->title);
	}

	public function actionIndex($id=false)
	{
		$this->render('index');
	}

	public function actionEdit($id=false)
	{
		if ($id)
			$user = User::model()->findByPk($id);
		else
			$user = new User;
		if (Yii::app()->request->isPostRequest)
		{
			$pass = $user->password;
			$user->attributes = $_POST['user'];
			if ($user->password)
				$user->HashPassword();
			else
				$user->password = $pass;

			$utms_array = [];
			if ($user->id)
			{
				$utms = Utm::model()->findAllByAttributes(['id_user'=>$user->id]);
				foreach ($utms as $utm)
					$utms_array[$utm->utm_source] = $utm;
			}
			$utm_sources = Yii::app()->request->getParam('utm_sources');
			foreach (explode(',', $utm_sources) as $utm_source)
			{
				if (!($utm_source = trim($utm_source))) continue;
				if (isset($utms_array[$utm_source])) 
				{
					unset($utms_array[$utm_source]);
					continue;
				}
				$utm = new Utm;
				$utm->id_user = $user->id;
				$utm->utm_source = $utm_source;
				$utm->save();
			}
			foreach ($utms_array as $utm)
				$utm->delete();

			$user->save();
			$this->redirect('/admin/users');
		}
		$utm_sources = [];
		if ($user->id)
		{
			$utms = Utm::model()->findAllByAttributes(['id_user'=>$user->id]);
			foreach ($utms as $utm)
				$utm_sources[] = $utm->utm_source;
			$customers = User::model()->findAll(['condition'=>'is_customer=1 AND id<>'.$user->id]);
		}
		else
			$customers = User::model()->findAll(['condition'=>'is_customer=1']);
		$allowed_customers = [];
		$blocked_customers = [];
		foreach ($customers as $c)
		{
			if (($limit = $user->GetCustomerLimit($c->id)) !== 0)
				$allowed_customers[] = ['id'=>$c->id, 'name'=>$c->name, 'limit'=>$limit];
			else
				$blocked_customers[] = ['id'=>$c->id, 'name'=>$c->name];
		}

		$this->render('edit', ['user'=>$user, 'utm_sources'=>implode(',',$utm_sources), 
			'allowed_customers'=>$allowed_customers, 'blocked_customers' => $blocked_customers]);
	}

	public function actionAjax()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('deleted', 0);
		list($users, $n, $count) = DatatableHelper::GetRecords('User', [], false, $criteria);

		$res = [];
		foreach ($users as $user)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $user->id;
			$tmp['name'] = $user->name;
			$tmp['uid'] = $user->uid;
			$tmp['is_customer'] = $user->is_customer ? 'Да' : 'Нет';
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionDelete($id)
	{
		$user = User::model()->findByPk($id);
		if ($user)
		{
			$user->deleted = 1;
			$user->update(['deleted']);
		}
	}
}