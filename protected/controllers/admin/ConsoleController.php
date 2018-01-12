<?php

class ConsoleController extends CAdminController
{
	public function init()
	{
		$this->title = 'Консоль';
		$this->breadcrumbs[] = array('name' => $this->title);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionAjax()
	{
		$result = '';
        ob_start();
        if (isset($_POST['code']))
        {
            $code = $_POST['code'];
            eval($_POST['code']);
        }
        $result = ob_get_contents();
        ob_end_clean();

		if($result === '')
			echo 'Complete';
		else
			echo $result;
	}
}