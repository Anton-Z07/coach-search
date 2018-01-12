<?php

class CronTaskWorker 
{
	public function run( $job_id=0, $worker_id = -1, $data='', $queue='queue' )
	{
		$data = json_decode($data,1);
		if (!$data || !isset($data['method']) || !$data['method']) return false;

		$method = $data['method'];
		echo "Cron::{$method}: ";
		$t = microtime(1);
		$success = 0;
		$e = '';
		try {
			if (CLock::tryAdd('cron_'.$method)) {
				Cron::{$method}();
				$success = 1;
				CLock::release('cron_'.$method);
			}
		}
		catch (Exception $e) {
			var_dump($e);
			$success = 0;
		}
		$dt = round( microtime(1) - $t, 1 );
		echo "{$dt}s <br />";

		Common::Log("<{$data['method']}> {$dt}s success: $success. ex: " . print_r($e,1), __CLASS__.'Log.txt');
		return true;	
	}
}
?>