<?php 

class AddCronTasksCommand extends CConsoleCommand
{
	public function actionIndex()
	{
		Cron::CreateTasks();
	}
}
?>