<?php

class CCoachController extends Controller
{
    public $breadcrumbs = array(array('name' => 'Главная', 'url' => '/coach'));
    public $layout = 'coach';
    
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
                'expression'=>'$user->isGuest || $user->type !== "coach"',
            ),
        );
    }
}