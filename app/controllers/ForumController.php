<?php
///BackUP

class ForumController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout=false;
	private $per_page = 5;

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','AjaxHottestArticle', 'AjaxAllArticle', 'AjaxNewestArticle', 'search'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updateComment','deleteArticle','deleteComment'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function beforeAction($action) // only index use get
	{
		if(strtolower($action->id)==='index')
			$this->layout='//layouts/main';
		else
		{
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(array('forum/index'));
				return false;
			}
			$this->disableGlobalJS();
		}
		parent::beforeAction($action);
		$this->setPageTitle('新生論壇');
		return true;
	}

	public function actionAjaxHottestArticle()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.views DESC, t.post_time DESC',
			'limit'=>$this->per_page,
		));
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));	
		$this->render('_article_list',array(
			'dataProvider'=>$dataProvider,
			'type'=>'hottest',
			'hmvn'=>$this->getHottestMinNum(),
		));
	}

	public function actionAjaxNewestArticle()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.post_time DESC, c.post_time DESC',
			'limit'=>$this->per_page,
		));
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));	
		$this->renderPartial('_article_list',array(
			'dataProvider'=>$dataProvider,
			'type'=>'newest',
			'hmvn'=>$this->getHottestMinNum(),
		));
	}

	public function actionAjaxAllArticle()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.to_top DESC, c.post_time DESC, t.post_time DESC',
		));
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$this->per_page),
		));	

		$this->render('_article_list',array(
			'dataProvider'=>$dataProvider,
			'type'=>'all',
			'hmvn'=>$this->getHottestMinNum(),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$comment = new Comments;
		$article_model = $this->loadModel($id);
		$sort_tag = $article_model->sort;
		//var_dump($_POST['Comments']);

		if(isset($_POST['Comments'])&&!Yii::app()->user->isGuest)
		{
			$comment->attributes=$_POST['Comments'];
			$comment->setArticleId($id);

			$comment->auth_id = Yii::app()->user->id;

			// Yii::app()->end();
			if($comment->save())
				Yii::app()->end();
			else
			{
				if($comment->hasErrors()){
					echo CHtml::errorSummary($comment,'');
					Yii::app()->end();
				}
				Yii::app()->end();
			}
				
		}
		else
		{
			$article_model->update_views = true;
			$article_model->views = $article_model->views+1;
			$article_model->update();
		}

		$dataProvider =  new CArrayDataProvider(
			$article_model->comments,
			array(
				'pagination'=>array(
					'pageSize'=>3,
					'route'=>'forum/view',
				),
			)
		);
		
		$this->renderPartial('view',array(
				'model'=>$article_model,
				'comment'=>$comment,
				'comments'=>$dataProvider,
				'sort_tag'=>$sort_tag,
				'sort'=>SortTag::model()->findAll(),
				// 'grid'=>$grid,
			),
			false,
			true
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Article;
		$sort = SortTag::model()->findAll();
		$sort_tag = new SortTag;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(Yii::app()->user->isGuest)
		{
			echo '孩子 登入吧';
			Yii::app()->end();
		}

		if(isset($_POST['Article'])&&isset($_POST['SortTag']))
		{
			$criteria=new CDbCriteria(array(
				'select'=>"t.*",
				'condition'=>'auth_id=:uid',
				'order'=>'t.post_time DESC',
				'limit'=>'1',
				'params'=>array(
					':uid'=>Yii::app()->user->id,
				),
			));
			$dataProvider=new CActiveDataProvider(Article::model(), array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));
			// $criteria->group='t.id';
			if($dataProvider->getItemCount()>0)
			{
				$newest_article = $dataProvider->getData()[0];
				if(strtotime($newest_article->post_time) >= (time() - 10 * 60))
				{
					echo '十分鐘之內只能發一次文喔！';
					Yii::app()->end();
				}
			}
			$model->attributes=$_POST['Article'];
			$model->sort_id = $_POST['SortTag']['id'];
			$model->auth_id = Yii::app()->user->id; // for real env
			if($model->validate(array('sort_id')))
				$sort_tag = $model->sort;
			if($model->save())
			{
				echo 'a'.$model->id;
				Yii::app()->end();
			}
				
		}
		if($model->hasErrors()){
			echo CHtml::errorSummary($model,'');
			Yii::app()->end();
		}
		$this->renderPartial('create',array(
			'model'=>$model,
			'sort'=>$sort,
			'sort_tag'=>$sort_tag,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if($model===null)
		{
			echo 'error安安你好';
			Yii::app()->end();
		}
		if(Yii::app()->user->isGuest||Yii::app()->user->id!=$model->auth_id)
		{
			echo 'error安安你好';
			Yii::app()->end();
		}
			

		$sort_tag = new SortTag;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$sort = SortTag::model()->findAll();
		if(isset($_POST['Article'])&&isset($_POST['SortTag']))
		{
			$model->sort_id = $_POST['SortTag']['id'];
			$model->attributes=$_POST['Article'];
			if($model->validate(array('sort_id')))
				$sort_tag = $model->sort;
			if($model->save())
			{
				Yii::app()->end();
			}
				
		}
		if($model->hasErrors()){
			echo CHtml::errorSummary($model,'');
		}
		Yii::app()->end();
	}

	public function actionUpdateComment($id)
	{
		$model=Comments::model()->findByPk($id);
		if($model===null)
			$this->redirect(array('forum/index'));
		if(Yii::app()->user->isGuest||$model->auth_id!=Yii::app()->user->id)
		{
			echo 'error安安你好';
			Yii::app()->end();
		}
			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];
			if($model->save())
				Yii::app()->end();
		}
		if($model->hasErrors()){
			echo CHtml::errorSummary($model,'');
		}
		Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id=0)
	{
		$search = Article::model();
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.to_top DESC, c.post_time DESC, t.post_time DESC',
		));
		// $criteria->order='to_top DESC, comments.post_time DESC, comments.post_time DESC';

		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$this->per_page),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'type'=>'all',
			'search'=>$search,
			'initId'=>$id,
			'hmvn'=>$this->getHottestMinNum(),
		));
	}

	public function actionDeleteArticle($id)
	{
		$model=$this->loadModel($id);
		if($model===null)
		{
			echo 'error';
			Yii::app()->end();
		}
		if(Yii::app()->user->isGuest||Yii::app()->user->id!=$model->auth_id)
		{
			echo '你哪位';
			Yii::app()->end();
		}
		$model->delete();
		Yii::app()->end();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	}

	public function actionDeleteComment($id)
	{
		$model=Comments::model()->findByPk($id);
		if(Yii::app()->user->isGuest||Yii::app()->user->id!=$model->auth_id)
		{
			echo '你哪位';
			Yii::app()->end();
		}
		$model->delete();
		Yii::app()->end();
	}

	private function getHottestMinNum()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.views DESC, t.post_time DESC',
			'limit'=>$this->per_page,
		));
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
		// $criteria->group='t.id';
		if($dataProvider->getItemCount()>0)
			$hdd=$dataProvider->getData()[$dataProvider->getItemCount()-1];
		else
			$hdd=0;
		return $hdd['views'];
	}

	private function disableGlobalJS()
	{	


	}

	public function actionSearch()
	{
		if(!Yii::app()->request->isAjaxRequest)
		{
			$this->redirect(array('forum/index'));
			Yii::app()->end();
		}
		if(isset($_GET['ajax']))
		{
			if(isset(Yii::app()->session['forum_search_str']))
				$str = Yii::app()->session['forum_search_str'];
			else
				Yii::app()->end();
		}
		else
		{
			if(!isset($_POST['search_str'])||$_POST['search_str']=='')
			{
				echo '<div class="forum_grid_view_prompt">請輸入搜尋內容</div>';
				Yii::app()->end();
			}
			else
			{
				$str = $_POST['search_str'];
				Yii::app()->session['forum_search_str'] = $str;
			}
		}	
		
		
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		$match = preg_split("/[,. +]/", $str);
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id INNER JOIN general_user_profile u ON u.uid=t.auth_id INNER JOIN forum_sort_tag s ON s.id=t.sort_id',
			'group'=>'t.id',
			'order'=>'t.to_top DESC, c.post_time DESC, t.post_time DESC',
		));
		foreach($match as $m) {
            $criteria->addSearchCondition('t.title',$m,true,'OR');
            $criteria->addSearchCondition('t.content',$m,true,'OR');
            //$criteria->addSearchCondition('c.content',$m,true,'OR');
            $criteria->addSearchCondition('u.nickname',$m,true,'OR');
            $criteria->addSearchCondition('s.name',$m,true,'OR');
            //$criteria->addSearchCondition('t.auth',$m);
        } 
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$this->per_page),
		));	
		$this->layout=false;
		$this->render('_article_list',array(
			'dataProvider'=>$dataProvider,
			'type'=>'search',
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
		{
			echo 'error安安你好';
			Yii::app()->end();
		}
		return $model;
	}
}
