<?php

class TravelModule extends CWebModule
{


	public function init()
	{

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'travel.models.*',
			'travel.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
        $controller->layout = '//layouts/main';

		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}


}
