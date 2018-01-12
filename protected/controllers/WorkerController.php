<?php 

class WorkerController extends Controller
{
	public $layout = false;

	private $worker_id;
	private $worker_queue;
	private $dated = 0;
	private $with_speed = 0;
	private $worker_type = '';
	private $queue_class = '';
	
	

	public function actionIndex()
	{
		$this->worker_id =  (int) Yii::app()->request->getParam('wid', -1);
		$this->worker_queue =  Yii::app()->request->getParam('queue', 'queue');
		$this->dated =  Yii::app()->request->getParam('dated', 0);
		$this->with_speed =  Yii::app()->request->getParam('with_speed', 0);
		foreach (explode('_', str_replace('queue_', '', $this->worker_queue)) as $word)
		{
			$this->worker_type .= ucfirst($word);
			$this->queue_class .= ucfirst($word);
		}
		$this->worker_type .= 'Worker';
		$this->queue_class = 'Queue' . $this->queue_class;

		// if (in_array($this->queue_class, Settings::GetDecoded('paused_queues'))) {
		// 	echo 'paused';
		// 	sleep( 5 );
		// 	return;
		// }

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

	public function actionExec()
	{
		$this->worker_id = 0;
		$this->worker_queue =  Yii::app()->request->getParam('queue', 'queue');
		foreach (explode('_', str_replace('queue_', '', $this->worker_queue)) as $word)
		{
			$this->worker_type .= ucfirst($word);
			$this->queue_class .= ucfirst($word);
		}
		$this->worker_type .= 'Worker';
		$this->queue_class = 'Queue' . $this->queue_class;
		$id = U::gi('id');

		if ( file_exists( YiiBase::getPathOfAlias( 'application.workers.' . $this->worker_type ) . '.php' ) ) {
			$cn = $this->queue_class;
			$rec = $cn::model()->findByPk($id);
			if ($rec) {
				$rec->worker_id = $this->worker_id;
				$rec->date_start = date('Y-m-d H:i:s');
				$rec->update(['worker_id', 'date_start']);
				Yii::import( 'application.workers.' . $this->worker_type );
				$worker = new $this->worker_type;
				
				$cn = $this->queue_class;
				if ( $worker -> run( $rec->id, $this->worker_id, $rec->data, $this->worker_queue ) ) {
					$rec->delete();
				} elseif ($cn::hasBuffer()) {
					$cn::AddDatedTask($rec->data, date('Y-m-d H:i:s', time()+900));
					$rec->delete();
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
		echo "get count time: " . (microtime(1) - $t) . '<br />';
		echo "count: $count<Br />";
		if ($count < 50 && $this->worker_id>0) return false;
		if ($count < 100 && $this->worker_id>1) return false;
		$max_offset = min(10000, $count - 1);
		$q->offset = rand(0, $max_offset);
		echo "offset: " . ($q->offset) . '<br />';
		$q->limit = 1;
		$rec = $cn::model()->find($q);
		echo "getRec: " . (microtime(1) - $t) . '<br />';
		return $rec;
	}
}
?>