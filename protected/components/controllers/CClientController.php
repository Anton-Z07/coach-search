<?php

class CClientController extends Controller
{
    public $breadcrumbs = array(array('name' => 'Главная', 'url' => '/client'));
    public $layout = 'client';
    
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
            	'users'=>array('?')
            ),
            array('deny',
                'users'=>array('@'),
                'expression'=>'$user->isGuest || $user->type !== "client"',
            ),
        );
    }
}