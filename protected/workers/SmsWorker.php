<?php

class SmsWorker 
{
	public function run( $job_id=0, $worker_id = -1, $data='', $queue='queue' )
	{
		$data = json_decode($data,1);
		if (!$data || !isset($data['id_sms']) || !$data['id_sms']) return false;

		$sms = Sms::findById($data['id_sms']);
		if (!$sms)
			return true;
		$result = $sms->Send();

		Common::Log("<{$sms->id}> ".print_r($result, 1), __CLASS__.'Log.txt');
		return true;
	}
}
?>