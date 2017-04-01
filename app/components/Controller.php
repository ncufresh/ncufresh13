

<?php

/**
 * 
 */
class Controller extends CController
{
    public function beforeRender($view){

	$cs=Yii::app()->clientScript;
	$cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/bootstrap.css');
	$cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/main.css');
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('jquery.ui');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/app/js/script.js');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/app/js/waitforimages.js');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/app/js/bootstrap.js');
	return  parent::beforeRender($view);
	}

	public function filters()
    {
        return array(
            'accessControl',
        );
    }
	

	// -----------------------------------------------------------
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
?>