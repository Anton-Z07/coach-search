<?php

class ClientsController extends CAdminController
{
	public function init()
	{
		$this->title = 'Клиенты';
		$this->breadcrumbs[] = array('url' => '/admin/clients', 'name' => $this->title);
	}

	public function actionIndex($id=false)
	{
		$this->render('index');
	}

	public function actionEdit($id=false)
	{
		$this->title = 'Управление клиентом';
		$this->breadcrumbs[] = ['name' => $this->title];

		if ($id)
		{
			$client = Client::findById($id);
		}
		else
		{
			$client = new Client;
		}
		if (Yii::app()->request->isPostRequest)
		{
			$pass = $client->password;
			$client->attributes = $_POST['client'];
			if ($client->password)
				$client->password = CPasswordHelper::hashPassword($client->password, 11);
			else
				$client->password = $pass;

			if ($client->save())
			{	
				$this->redirect('/admin/clients');
			}
		}

		$this->render('edit', ['client'=>$client]);
	}

	public function actionAjax()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('deleted', 0);
		list($clients, $n, $count) = DatatableHelper::GetRecords('Client', [], false, $criteria);

		$res = [];
		foreach ($clients as $client)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $client->id;
			$tmp['name'] = $client->name;
			$tmp['login'] = $client->login;
			$tmp['uid'] = $client->uid;
			$tmp['balance'] = $client->balance . ' руб';
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionDelete($id)
	{
		$client = Client::model()->findByPk($id);
		if ($client)
		{
			$client->deleted = 1;
			$client->update('deleted');
		}
	}

	public function actionBalance()
	{
		$client = Client::findById($_POST['id_client']);
		if ($client) {
			$diff = intval($_POST['balance']);
			$client->balance += $diff;
			$client->update('balance');
			$this->redirect('/admin/clients');
		}
	}
}