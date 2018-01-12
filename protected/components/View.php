<?php
class View {
	public static function getPartial($name, $params=[])
	{
		// if(is_array($params))
		// 	extract($params,EXTR_PREFIX_SAME,'data');
		// else
		// 	$data=$params;

		// ob_start();
		// ob_implicit_flush(false);
		// require(Common::BaseDir().'/protected/views/view/'.$name.'.php');
		// return ob_get_clean();


		$controller = new Controller('view');
		ob_start();
		$controller->renderPartial($name, $params);
		$piece = ob_get_contents();
		ob_end_clean();
		return $piece;
	}	
}