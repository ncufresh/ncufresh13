<?php

	class MajorClubController extends Controller
{
	private $upload_location="./file/majorclub_pictures/";
	private $username='NCUCSIE';// check the certain editor, username=='e_name' 
	private $admin=0;// check admin, admin== 1 

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'catalog' and 'entries' and 'final' actions
				'actions'=>array('index','catalog','entries','final','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'edit' and 'create' and 'delete' actions
				'actions'=>array('edit','update','delete','uploadImage'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('edit','update','delete','uploadImage'),
				'users'=>Yii::app()->params['admin'],
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex(){
		$data=array(
				'direct'=> false
				);
		$this->render('index',$data);

	}
	public function actionView()
	{
		if(isset($_GET['select'])){
			$criteria=new CDbCriteria;
			$criteria->select='*';  
			$criteria->condition='e_name=:n';
			$criteria->params=array(':n'=> $_GET['select']);
			$record=MajorClubForm::model()->find($criteria);
			$data=array(
				'direct'=> true,
				'first' => "'".$record->catalog."'",
				'second'=> "'".$record->catalog.$record->catalogdetal."'",
				'e_name'=> "'".$record->e_name."'",
				);
		}else{
			$data=array(
				'direct'=> false
				);
		}
		$this->render('index',$data);
	}

	public function actionCatalog()// three catalog
	{
		$firstCatalog=$_GET['id'];// get var'firstCatalog'{major,club,stu} from majorclubIntro.js
		if($firstCatalog==0){
			$second_pic_array = $data=array('qua_ea','qua_wo','qua_the','qua_in','qua_mn','qua_li','qua_hak');;
		}else if($firstCatalog==1){
			$second_pic_array = array('qual_team','qual_stu');
		}else if($firstCatalog==2){
			$second_pic_array = array('qual_luv','qual_help','qual_play','qual_learn');
		}
		$data = array('firstCatalog' => $firstCatalog , 'second_pic_array' => $second_pic_array );
		$ajaxReturn['html']=$this->renderPartial('_secondCatalog',$data,true,true);
		$ajaxReturn['picArr']=$second_pic_array;
		echo CJSON::encode($ajaxReturn);
	}

	public function actionEntries()// entries
	{
		$catalog= $_GET['catalog'];
		$quality = $this->switchQua($catalog);
		$array = array('data' => $quality,'catalog'=>$catalog );
		$this->renderPartial('_entries',$array,false,true);

	}
	public function actionFinal(){
		if(isset($_GET['selectEntries']))// get the entry name from entries.js
			$select=$_GET['selectEntries'];
		else
			throw new CHttpException(404,'The specified post cannot be found.');

		$criteria=new CDbCriteria;
		$criteria->select='*';  
		$criteria->condition='e_name=:n';
		$criteria->params=array(':n'=> $select);
		$record=MajorClubForm::model()->find($criteria);
		$picArr=scandir($this->upload_location.$record->e_name);

		$data=array(
			'data' => $record->attributes,
			'picArr'=>$picArr,
			'editable'=>self::isAuthor($select)||self::isAdmin()
			);

		$ajaxReturn['html']=$this->renderPartial('_MajorClub',$data,true,true);// ('view.php',$giveVar,false,true)
		$ajaxReturn['picArr']=$picArr;
		$ajaxReturn['catalog']=$record->catalog;
		echo CJSON::encode($ajaxReturn);
	}
	public function actionEdit()// final part, float to top
	{
		
		if(isset($_GET['selectEntries'])){// get the entry name from entries.js
			$select=$_GET['selectEntries'];
		}else
			throw new CHttpException(404,'找不到頁面');

		$criteria=new CDbCriteria;
		$criteria->select='*';  
		$criteria->condition='e_name=:n';
		$criteria->params=array(':n'=> $select);
		$record=MajorClubForm::model()->find($criteria);
		
		$picArr=scandir($this->upload_location.$record->e_name);
		$formModel=new MajorClubForm;
		$imgModel=new ImageModel;
		$data=array(
			'data' => $record->attributes,
			'picArr'=>$picArr,
			'formModel'=>$record,
			'imgModel'=>$imgModel
			);

		$ajaxReturn['html']=$this->renderPartial('_editIntro',$data,true,true);// ('view.php',$giveVar,false,true)
		$ajaxReturn['picArr']=$picArr;
		$ajaxReturn['status']='success';
		echo CJSON::encode($ajaxReturn);
	}


	

	public function actionUpdate(){
		//記得確認id是否和帳號權限相同
		$form= MajorClubForm::model()->findByPk($_POST['MajorClubForm']['id']);
		if(!$this->isAuthor($form->e_name)&&!$this->isAdmin()){
			throw new CHttpException(403,'你沒有權限載入這個頁面');
			return;
		}
		if(isset($_POST['MajorClubForm']['intro'])){
			$form->intro=$_POST['MajorClubForm']['intro'];
		}

		if(isset($_POST['MajorClubForm']['fb'])){
			$form->fb=$_POST['MajorClubForm']['fb'];
		}

		if(isset($_POST['MajorClubForm']['contact1_name'])){
			$form->contact1_name=$_POST['MajorClubForm']['contact1_name'];
		}

		if(isset($_POST['MajorClubForm']['contact1_fb'])){
			$form->contact1_fb=$_POST['MajorClubForm']['contact1_fb'];
		}

		if(isset($_POST['MajorClubForm']['contact1_email'])){
			$form->contact1_email=$_POST['MajorClubForm']['contact1_email'];
		}

		if(isset($_POST['MajorClubForm']['contact2_name'])){
			$form->contact2_name=$_POST['MajorClubForm']['contact2_name'];
		}

		if(isset($_POST['MajorClubForm']['contact2_fb'])){
			$form->contact2_fb=$_POST['MajorClubForm']['contact2_fb'];
		}

		if(isset($_POST['MajorClubForm']['contact2_email'])){
			$form->contact2_email=$_POST['MajorClubForm']['contact2_email'];
		}
		$picArr=scandir($this->upload_location.$form->e_name);
		if($form->save()){
			$passData=array(
				'status'=>'success',
				);
		}else{
			$passData=array(
				'status'=>'fail',
				);
		}
		echo CJSON::encode($passData);
		
		
	}
	public function actionUploadImage(){
		//記得確認e_name是否和帳號權限相同
		$clubModel=MajorClubForm::model()->findByPk($_POST['MajorClubForm']['id']);
		if(!$this->isAuthor($clubModel->e_name)&&!$this->isAdmin()){
			throw new CHttpException(403,'你沒有權限載入這個頁面');
			return;
		}
		$model=new ImageModel;
		if(isset($_POST['ImageModel'])){
			$model->attributes=$_POST['ImageModel'];
			
			$model->image=CUploadedFile::getInstance($model,'image');
			$picArr=scandir($this->upload_location.$clubModel->e_name);
			$filename=time().'.'.$model->image->getExtensionName();
			if ($model->image!==null&&$model->validate()&&count($picArr)<7){
    			$model->image->saveAs($this->upload_location.$clubModel->e_name."/".$filename);
    			$this->redirect('view/'.$clubModel->e_name.'.html');
    		}else{
    			$data=array(
	    			'error' => '上傳錯誤 5秒後回到上一頁',
	    			'returnUri'=>$this->createUrl('majorClub/view',array('select'=>$clubModel->e_name))
	    		);
	    		$this->render('error',$data);
	    	
    		}

		}
	}

    public function actionDelete(){
    	//check e_name is exist in database
    	if(!$this->isAuthor($_POST['e_name'])&&!$this->isAdmin()){
			throw new CHttpException(403,'你沒有權限載入這個頁面');
			return;
		}
    	$criteria=new CDbCriteria;
		$criteria->select='*';  
		$criteria->condition='e_name=:n';
		$criteria->params=array(':n'=> $_POST['e_name']);
		if(MajorClubForm::model()->exists($criteria)){
	    	$picArr=scandir($this->upload_location.$_POST['e_name']);
	    	$path=$this->upload_location.$_POST['e_name']."/".$_POST['picname'];
	    	if(in_array($_POST['picname'],$picArr)){
	    		unlink($path);
	    		$this->redirect('view/'.$_POST['e_name'].'.html');
	    	}else{
	    		$data=array(
	    			'error' => '刪除錯誤 5秒後回到上一頁',
	    			'returnUri'=>$this->createUrl('majorClub/view',array('select'=>$_POST['e_name']))
	    		);
	    		$this->render('error',$data);
	    	}
    	}


    	$data=array(
	    			'error' => '權限錯誤 5秒後回到上一頁',
	    			'returnUri'=>$this->createUrl('majorClub/index')
	    		);
	    $this->render('error',$data);
    }
    private function switchQua($catalog)
	{	
		$firstCatalog=$catalog{0};
		$secondCatalog=$catalog{1};
		$post=MajorClubForm::model()->findAll(array('select'=>'*',
									    'condition'=>'catalog=:cata1 AND catalogdetal=:cata2',
									    'params'=>array(':cata1'=> $firstCatalog , 'cata2'=>$secondCatalog)
									));
		$data=array();// $post 二維[第幾row][columnName] , $data 一維, $thisData 一維
		foreach($post as $thisData){
			array_push($data, $thisData['e_name']);// push value $thisData['e_name'] into $data
		}
			// $data=array($post[0]['e_name'],$post[1]['e_name'],$post[2]['e_name']);
        return $data;
	}
    private function isAuthor($select){
    	return ($select==Yii::app()->user->getName());
    }
    private function isAdmin(){
    	return (Yii::app()->user->getState('admin')==1&&in_array(Yii::app()->user->getName(),Yii::app()->params['admin']));
    }
    public function init(){
    	$this->pageTitle=Yii::app()->name . ' - 系所社團';//set title
    }
}

?>