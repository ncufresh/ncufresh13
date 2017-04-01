<?php

class FreshmanreadController extends Controller
{
	public function actionAjaxFreshmanreadData()
	{
		//---$data = array() ;
		//---$model=new SpecialForm ;
		//---$data=SpecialForm::model()->select='title';
		//$data["title"] = ($model->reminder_title);
		
        //---$this->renderPartial('special', $data, false, true);
		
		//$this->load->model('SpecialForm');
		//$data['query'] = $this->blog_model->getdata();		
		
		//$this->render('special');

		$model=new FreshmanreadForm ; 
		$criteria=new CDbCriteria; 

		$criteria->select='*' ;
		//$criteria->select='reminder_title, reminder_content';  // only select the 'reminder_title' and 'reminder_content' column
		
		//$criteria->condition='reminder_id=:postID';//選取特定id的號碼
		//$criteria->params=array(':postID'=>2);
		
		$model=FreshmanreadForm::model()->find($criteria); // $params is not needed
		//$array=CHtml::listData($model,'reminder_id','reminder_title','reminder_content');
		//var_dump($model);//顯示model裡面的東西
		
		//var_dump($model->attributes);//var_dump道出所有東西，attribute顯示所有東西
		//var_dump($model->reminder_title);

		$data=array('d'=>$model->attributes);// put $model in an array
		//$this->renderPartial('_ajaxFreshmanreadData', $data, false, true);

		$category=$_GET['category'] ;
		$receipt=$_GET['receipt'];
		$view=$category."/_".$receipt;
		$this->renderPartial($view);//view是filename
	}

	public function actionIndex()
	{
		$this->render('reminder');
	}

	public function actionReminder2()
	{
		$this->renderPartial('reminder2');
	}

	public function actionAjax(){
		$s=$_GET['son'];
		$this->renderPartial('_ajax'.$s."");
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

	public function init(){
		$this->pageTitle=Yii::app()->name . ' - 大一必讀';//set title
	}
}

?>