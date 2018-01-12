<?php

class UploadController extends CCoachController
{
	public function actionIndex()
	{
		
	}

	public function actionPhoto($dest)
	{
		if (!is_array($_FILES["images"]["error"])) return;
		if (!in_array($dest, ['profile', 'training'])) return;
		$allowed_types = array('image/jpeg', 'image/png');

		$key = 0;
		$error = $_FILES["images"]["error"][$key];

		if ($error == UPLOAD_ERR_OK) {
			$type = $_FILES["images"]["type"][$key];
			if (!in_array($type, $allowed_types))
			{
				echo json_encode(array('result'=>'error','description'=>'Неподдерживаемый тип изображения'));
				return;
			}
			$tmp_name = $_FILES["images"]["name"][$key];
			$ext = explode('.', $tmp_name);
			$ext = $ext[count($ext)-1];
			$name = sha1(mktime(true) . rand()) . ".$ext";
			$base_path = "/uploads/".$dest."s/coach_" . U::id();
			$dir_name = Common::BaseDir() . $base_path;
			if (!is_dir($dir_name))
				mkdir($dir_name);
			if (move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $dir_name . '/' . $name))
			{
				// Yii::import('ext.SimpleImage');
				// $image = new SimpleImage();
				// $image->load($dir_name . '/' . $name);
				// if ($image->getWidth() > $image->getHeight() and max($image->getWidth(), $image->getHeight()) > 900)
				// {
				//     $image->resizeToWidth(900);
				//     $image->save($dir_name . '/' . $name);
				// }
				// elseif (max($image->getWidth(), $image->getHeight()) > 900) {
				//     $image->resizeToHeight(900);
				//     $image->save($dir_name . '/' . $name);
				// }
			}
			$response = array('result' => 'ok', 'name' => $name, 
				'full_path' => $base_path . '/' . $name);
		}
		else
			$response = ['result'=>'error'];
		
		echo json_encode($response);
	}
}