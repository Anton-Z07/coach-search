<?php

class CronController extends CAdminController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSave()
	{
		$id = U::gi('id', false);
		$method = U::gp('method');
		$minutes = U::gp('minutes');
		if ($id) $t = CronTask::findById($id);
		else $t = new CronTask;

		$t->method = $method;
		$t->minutes = $minutes;
		$t->times = U::gp('times');
		$t->save();
		$this->redirect('/admin/cron');
	}

	public function actionDelete($id)
	{
		CronTask::model()->deleteByPk($id);
		$this->redirect('/admin/cron');
	}
}