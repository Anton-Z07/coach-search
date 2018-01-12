<?php 

class WorkerCommand extends CConsoleCommand
{
	private $worker_id;
	private $worker_queue;
	private $dated = 0;
	private $with_speed = 0;
	private $worker_type = '';
	private $queue_class = '';

	public function actionIndex($worker_id=-1, $worker_queue='queue', $dated = 0, $with_speed = 0)
	{
		$this->worker_id =  intval($worker_id);
		$this->worker_queue =  $worker_queue;
		$this->dated =  $dated;
		$this->with_speed =  $with_speed;
		foreach (explode('_', str_replace('queue_', '', $this->worker_queue)) as $word)
		{
			$this->worker_type .= ucfirst($word);
			$this->queue_class .= ucfirst($word);
		}
		$this->worker_type .= 'Worker';
		$this->queue_class = 'Queue' . $this->queue_class;

		//if (in_array($this->queue_class, Settings::GetDecoded('paused_queues'))) return;

		if ( ( $this->worker_id >= 0 ) && ( $this->worker_type != 'unknown' ) ) {
			if ( file_exists( YiiBase::getPathOfAlias( 'application.workers.' . $this->worker_type ) . '.php' ) ) {
				$it = 0;
				$rec = false;
				while ( !($rec = $this->getRec()) ) 
				{ 
					if ( ++$it > 10 ) exit; 
					sleep( 5 ); 
				}
				if ($rec) {
					$rec->worker_id = $this->worker_id;
					$rec->date_start = date('Y-m-d H:i:s');
					$rec->update(['worker_id', 'date_start']);
					Yii::import( 'application.workers.' . $this->worker_type );
					$worker = new $this->worker_type;
					
					$cn = $this->queue_class;
					if ( $worker -> run( $rec->id, $this->worker_id, $rec->data, $this->worker_queue ) ) {
						$rec->delete();
					} 
					// elseif ($cn::hasBuffer()) {
					// 	$cn::AddDatedTask($rec->data, date('Y-m-d H:i:s', time()+900));
					// 	$rec->delete();
					// }
				}
			}
		}
	}

	private function getRec()
	{
		$t = microtime(1);
		$q = new CDbCriteria;
		$cn = $this->queue_class;
		if ($this->dated)
			$q->addCondition('worker_id<0 AND NOW()>=planned_date_start');
		else
			$q->addCondition('worker_id<0');
		if ($this->with_speed)
			$q->addCondition("{$this->worker_id}<max_worker_num AND pause=0");

		$count = $cn::model()->count($q);
		//echo "get count time: " . (microtime(1) - $t) . '<br />';
		//echo "count: $count<Br />";
		if ($count < 30 && $this->worker_id>0) return false;
		if ($count < 60 && $this->worker_id>1) return false;
		$max_offset = min(10000, $count - 1);
		$q->offset = rand(0, $max_offset);
		//echo "offset: " . ($q->offset) . '<br />';
		$q->limit = 1;
		$rec = $cn::model()->find($q);
		//echo "getRec: " . (microtime(1) - $t) . '<br />';
		return $rec;
	}
}
?>