<?php
//the Controller of CampusTour
class CampusTourController extends Controller
{	//set function accessRules
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'motionDetail'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	//the initial action of CampusTour 
	public function actionIndex()
	{
		$this->render('index');
	}
	//the action named motiondetail
	public function actionMotionDetail()
	{
		if (Yii::app()->request->isAjaxRequest && isset($_GET['select'])) 
		{
			$select=$_GET['select'];
			$partialView='_'.$select;

			$googlemapModel = new GooglemapModel;
			$googlemapModel->name = $select;
			$record=$googlemapModel -> getGooglemap();

			$html=$this->renderPartial($partialView,array(),true);
			$data=array(
					'html' => $html,
					'panorama' =>array('lat' => $record -> lat,
										'lon' => $record -> lon,
										'heading' => $record -> heading,
										'zoom' => $record -> zoom)
				);
			echo CJSON::encode($data);
		}

		else
		{
			$this->redirect("index.html");
		}
	}
	//set function init
	public function init()
	{
		$this->pageTitle=Yii::app()->name . ' - 校園導覽';
	}
}
?>