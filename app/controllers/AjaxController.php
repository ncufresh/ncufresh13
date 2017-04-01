<?php

class AjaxController extends Controller{
	public function action(){
	

}
	//	/**
//	 * @return array action filters
//	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
//
//	/**
//	 * Specifies the access control rules.
//	 * This method is used by the 'accessControl' filter.
//	 * @return array access control rules
//	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to access 'index' and 'view' actions.
//				'actions'=>array('index', 'error'),
//				'users'=>array('*'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}




	public function accessRules(){
		return array(
			array('allow',
				'actions'=>array('index'),
				'users'=>array('*'), //every
			),

			array('allow',
				'actions'=>array('login'),
				'users'=>array('@'), //login
			),
			array('allow',
				'actions' => array('hi'),
				'users' => Yii::app()->params['admin'],
				'message'=>'Access Denied.',
			),
			array('allow',  // deny all users
				'users'=>array('*'), // all
			),
		);
        
	}

	public function actionAjaxDynamicView(){
		$data=array(
			'title'		=>'jax測試',
			'content'	=>'簡單的ajax更新的內容'
			);
		$this->renderPartial('_ajaxDynamic',$data,false,true);
	}

	public function actionLogin(){
		echo "login";
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

	public function actionHi(){
		echo "ADMIN";
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
}