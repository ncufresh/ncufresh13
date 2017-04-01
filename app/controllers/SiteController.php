<?php

class SiteController extends Controller
{
	public function init(){
		$this->pageTitle=Yii::app()->name . ' - 首頁';
	}
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','news','error','login','register'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('logout'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('editNews','addNews'),
				'users'=>Yii::app()->params['admin'],
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//Yii::trace('message','cate');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$newsProvider = new CActiveDataProvider("News",array(
				'sort'=>array(
	                'defaultOrder'=>'t.id DESC',
	            ),
				'pagination'=>array(
				      'pageSize'=>14,
			    ),

			)
		);


		$obj =  new video_videoid;
		$hotvideoid=$obj->gethotvideoid(7);

		$model=new CalendarForm ;
		$criteria=new CDbCriteria;
		$criteria->select='*';
		$model=CalendarForm::model()->findAll($criteria); // $params is not needed

		$array=array() ;		
		foreach ($model as $thisData) {
			array_push($array, $thisData) ;
		}
		
		// $data=array('d'=>$model->attributes,
		// 			'arrayValue'=>$array);// put $model in an array

		$hotarticle=Article::model()->getNewestArticle();

		$this->render('index',array(
			'newsProvider' => $newsProvider,
			'arrayValue'=>$array,
			'hotvideoid'=>$hotvideoid,
			'hotarticle'=>$hotarticle,
			));
	}
	/**
	* this is view news articale
	*/
	public function actionNews($id){
		$this->renderPartial('_news',array(
			'data'=>$this->loadNews($id),
		));
	}
	/**
	* this is a function to load news' articale
	*/
	private function loadNews($id)
	{
		$model=News::model()->with('auth')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	* this is a function to edit news' artical
	*/
	public function actionEditNews($id)
	{
		$model=News::model()->findByPk($id);

		if(Yii::app()->user->getState('admin')!=1||!in_array(Yii::app()->user->getName(),Yii::app()->params['admin'])){
			throw new CHttpException(403,'You have no premit to this page');
			Yii::app()->end();
		}else{
			if(isset($_POST['News']))
			{
				$model->attributes=$_POST['News'];
				if($model->save())
					$this->redirect(Yii::app()->createUrl('site/index'));
			}

			$this->render('editNews',array(
				'model'=>$model,
			));
		}
	}
	/**
	* This is a action to create a new news
	*/
	public function actionAddNews()
	{
		if(Yii::app()->user->getState('admin')!=1||!in_array(Yii::app()->user->getName(),Yii::app()->params['admin'])){
			throw new CHttpException(403,'You have no premit to this page');
			Yii::app()->end();
		}else{
				$model=new News;
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);

				if(isset($_POST['News']))
				{
					$model->attributes =$_POST['News'];
					$model->auth_id    =Yii::app()->user->id;
					$model->post_time  =date ("Y-m-d H:i:s",time() );
					$model->views      =0;
					if($model->save())
						$this->redirect(Yii::app()->createUrl('site/index'));
				}

				$this->render('editNews',array(
					'model'=>$model,
				));
		}
	}


	/**
	 * This is the action to handle external exceptions.
	 */
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

	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// if it is ajax validation request
		if(Yii::app()->request->isAjaxRequest&&isset($_POST['GeneralUserProfile']))
		{
			$model = new GeneralUserProfile;
			if(Yii::app()->user->isGuest){
				$model->attributes=$_POST['GeneralUserProfile'];
				if($model->login()){
					Yii::app()->user->login($model->_identity,0);
					$message['login']='success';
					$message['id']=Yii::app()->user->getId();
					$message['imgUrl']=Html::getPersonalImgUrl(Yii::app()->user->getId());
					$message['profile']=
						$this->widget('LoginWidget',array(
							'model' => $model
						),true);
				}else{
					$message['login']='fail';
				}
			}else{
				$message['login']='relogin';
				$message['profile']=
						$this->widget('LoginWidget',array(
							'model' => $model
						),true);
			}
			$data=CJSON::encode($message);
			echo $data;

		}else{
			$this->redirect(Yii::app()->user->returnUrl);
		}
		
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		Yii::app()->user->clearStates();
		$this->redirect(Yii::app()->user->returnUrl);

	}


	public function actionRegister(){
		$register=new GeneralUserProfile('register');
		if(isset($_POST['GeneralUserProfile'])){
			$register->attributes=$_POST['GeneralUserProfile'];
			if($register->save()){		
				$this->redirect(array('site/index'));
				Yii::app()->end();
			}
		}
		$data=array('formModel'=>$register);
		$this->render('register',$data);
		

	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionTest()
	{
		
	}


}