<?php

class AboutController extends Controller
{	//set function accessRules
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'dialog'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	//the initial action of About
	public function actionIndex()
	{
		$this->render('index');
	}
	//the action named dialog
	public function actionDialog()
	{
		if (Yii::app()->request->isAjaxRequest && isset($_GET['select'])) 
		{
		$select=$_GET['select'];
		$partialView='_'.$select;

		$this->renderPartial($partialView);
		}

		else
		{
			$this->redirect("index.html");
		}
	}
	//set function init
	public function init()
	{
		$this->pageTitle=Yii::app()->name . ' - 關於我們';
	}
}

?>