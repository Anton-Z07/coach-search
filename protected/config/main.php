<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Couch search',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.models.queues.*',
		'application.components.*',
		'application.components.controllers.*',
		'application.components.interfaces.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		// 'cache'=>array(
  //           'class'=>'system.caching.CMemCache',
  //       ),
        
		'user'=>array(
			'allowAutoLogin'=>true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<folder:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<folder>/<controller>/<action>',
				'<folder2:\w+>/<folder1:\w+>/<controller:\w+>/<action:\w+>'=>'<folder2>/<folder1>/<controller>/<action>',
				'admin' => 'admin/home/index',
				'client' => 'client/home/index',
				'coach' => 'coach/home/index',
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/../../../config/couch/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
	'defaultController' => 'site',
);
