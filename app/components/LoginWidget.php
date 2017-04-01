<?php
	class LoginWidget extends CWidget{
		public $model;
		public function init(){	
        	parent::init();
		}
		public function run(){
			if(!Yii::app()->user->isGuest){
				$this->render('_profile');
			}else{
				$this->render('_login',array(
					'formModel'=> isset($this->model)?$this->model:new GeneralUserProfile)
				);
			}
		}
	}