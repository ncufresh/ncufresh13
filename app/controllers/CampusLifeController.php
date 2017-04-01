<?php

class CampusLifeController extends Controller{

	public function action(){

	}


	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('index','ajaxDynamicView'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAjaxDynamicView(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['select'])) {
			# code...
			$bUrl=Yii::app()->request->baseUrl;
			$select=$_GET['select'];
			$data=array('bUrl'=>$bUrl);
			$this->renderPartial($select,$data);
		}else{
			$this->redirect("index.html");
		}
	}
	
	public function actionIndex()
	{
		

		$data=array(
			'data'=>array(
				'title'		=>'',
				'content'	=>''
				)
		);
		$this->render('index',$data);
	}

	public function init(){
		$this->pageTitle=Yii::app()->name . ' - 中大生活';//set title
	}
	
}