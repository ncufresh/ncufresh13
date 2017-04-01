<?php
class VideoController extends Controller{

	public function action(){
		
	}
	public function actionHotvideo (){
		$vidnow=$_GET['select'];
		$obj = new video_videoid;
		$videoid=$obj->model()->findAll();
		$this->render('index',array('videoid'=>$videoid,'vidnow'=>$vidnow));
	}

	public function actionIndex (){
		$obj = new video_videoid;
		$videoid=$obj->model()->findAll();
		$this->render('index',array('videoid'=>$videoid));
	}

	public function actionAddmsg(){
		$msg=$_POST['msg'];
		$videoid=$_POST['videoid'];
		$obj = new video_message;
		$garbage=$obj->testmsg($msg);
		if($garbage<0){
			$result=$obj->addmsg($msg,$videoid);
			echo $result;	
		}
		else
			echo $garbage;
	}

	public function actionShowmsg(){
		$videoid=$_POST['videoid'];
		$msgrow=$_POST['msgrow'];
		//$getuserinfo=new UserModel;

		$msg=video_message::model()->getmessage(video_videoid::model()->videoidtovid($videoid),$msgrow);
		$end=video_message::model()->ifend(video_videoid::model()->videoidtovid($videoid),$msgrow);
		$this->renderPartial('_msgdisplay',array('msg'=>$msg,'end'=>$end),false,true);
	}

	public function init(){
		$this->pageTitle=Yii::app()->name . ' - 影音專區';//set title
	}
}
