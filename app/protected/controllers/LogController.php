<?php

class LogController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			array(
				'RestfullYii.filters.ERestFilter +
				REST.GET, REST.PUT, REST.POST, REST.DELETE, REST.OPTIONS'
			),
		);
	}

	public function actions()
	{
		return array(
			'REST.' => 'RestfullYii.actions.ERestActionProvider',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE', 'REST.OPTIONS'),
				'users' => array('*'),
			),
			array('deny',
				'users' => array('*'),
			),
		);
	}

	public function restEvents()
    {
    	$this->onRest('req.get.resource.render', function() {
    		//Custom logic for this route.
    		//Should output results.
    		$this->emitRest('req.render.json', [
    			[
    				'type'=>'raw',
    			]
    		]);
		});
	}
}