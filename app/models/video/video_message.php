<?php

class video_message extends CActiveRecord{

	public $uid;
    public $vid;
    public $msg;
    public $time;
    public $ip;


	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return 'video_message';
    }

    public function getmessage($vid,$offset){
        //這裡不用relation 改傳vid   yii limit會失敗
        $result = $this->findAll(array(
            'condition'=>'vid=:vid',
            'params'=>array(':vid'=>$vid),
            'limit'=>10,
            'offset'=>($offset*10),
            'order'=>'time DESC'));

        return $result;
    }

    public function ifend($vid,$offset){
        //這裡不用relation 改傳vid   yii limit會失敗
        $result = $this->findAll(array(
            'condition'=>'vid=:vid',
            'params'=>array(':vid'=>$vid),
            'limit'=>1,
            'offset'=>($offset+1)*10,
            'order'=>'time DESC'));
        if(empty($result))
            return true;
        else
            return false;
    }

    private function getRealIp(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
         return $ip;
    }

    public function testmsg($msg){
    
        if(strripos($msg,"<script")!==false||strripos($msg,"<form")!==false||strripos($msg,"<submit")!=false||strripos($msg,"<meta")!==false||strripos($msg,"<style")!=false)
            return 1;
        else if(mb_strlen($msg,'utf-8')>41)
            return 2;
        else if(strlen(trim($msg)) == 0)
            return 3;
        else 
            return -1;
    }

    public function addmsg($msg,$videoid){

        $temptime=date ("Y-m-d H:i:s");
        $this->uid=Yii::app()->user->getId();
        $this->ip=$this->getRealIp();// Yii::app()->request->getUserHostAddress();

        if($this->checktime($temptime)){
            $this->msg=$msg;
            $this->vid=video_videoid::model()->videoidtovid($videoid);
            $this->time=$temptime;
            $this->save();
            return 100;
        }
        else
             return 4;
    }

    private function checktime($timeadd){
        $o = $this->find(array(
        'condition'=>'uid=:uid',
        'params'=>array(':uid'=>$this->uid),
        'order'=>'time DESC'));
        if(empty($o))
            return true;
        else if(strtotime($timeadd)-strtotime($o->time)>60)
            return true;
        else 
            return false;

    }


    public function relations()
    {
        return array(
            'vid'=>array(self::BELONGS_TO, 'video_message', 'vid'),
            'guser'=>array(self::BELONGS_TO, 'GeneralUserProfile', array('uid'=>'uid'))
        );
    }

    public function attributeLabels()
    {
        return array(
            'vid' => 'vid',
            'uid' => 'uid',
            'msg' => 'msg',
            'time' => 'time',
            'ip' => 'ip'
        );
    }

}