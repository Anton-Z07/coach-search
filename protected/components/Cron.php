<?php

class Cron {
	public static function CreateTasks()
	{
		foreach (CronTask::findMany() as $t) {
			if ($times = $t->isRightTime()) 
				for ($i=0; $i<$times; $i++)
					QueueCronTask::addTask(json_encode(['method'=>$t->method]));
		}
	}

	public static function ProcessSmsUploads()
	{
		$upload = SmsUpload::findOne(['status'=>'work']);
		if (!$upload) return;

		$limit = 2000;
		$ext = Common::GetExt($upload->file);
		if ($ext == 'csv') {
			$excel_content = [];
			$content = file_get_contents(Common::BaseDir().'/tmp/'.$upload->file);
			foreach (explode("\n", $content) as $s)
				$excel_content[] = explode(';', $s);
			if ($upload->skip) $excel_content = array_slice($excel_content, $upload->skip);
		} else {
			require_once(Common::BaseDir().'/protected/extensions/PHPExcel.php');
			$excel = PHPExcel_IOFactory::load(Common::BaseDir().'/tmp/'.$upload->file);
			$sheets = $excel->getAllSheets();
			$sheet = $sheets[0];
			$highestRow = $sheet->getHighestRow(); 
			$highestRow = min($highestRow, $upload->skip + $limit + 1);
			$highestColumn = $sheet->getHighestDataColumn(); 
			$min = $upload->skip + 1;
			$excel_content = $sheet->rangeToArray("A{$min}:{$highestColumn}{$highestRow}");
		}
		$done = 0;
		$fields = json_decode($upload->data_cols,1);
		foreach ($excel_content as $row) {
			$phone = '';
			$body = '';
			foreach ($fields as $f=>$col) {
				if ($f == 'phone')
					$phone = $row[$col];
				if ($f == 'body')
					$body = $row[$col];
			}
			
			if (!$phone || !$body) continue;
			$phone = U::np($phone);
			$sms = new Sms;
			$sms->id_client = $upload->id_client;
			$sms->phone = $phone;
			$sms->body = $body;
			$sms->id_sms_upload = $upload->id;
			$sms->source = 'upload';
			$send_date = date('Y-m-d H:i:s', time() + rand(0, $upload->duration * 3600));
			if ($sms->save())
				QueueSms::AddDatedTask(json_encode(['id_sms'=>$sms->id]), $send_date);
			else
				var_dump($sms->getErrors());
			$upload->total++;
			$upload->skip++;
			$done++;
		}
		if (!$done) $upload->status = 'done';
		$upload->save();
	}
}