<?php

class video_videoid extends CActiveRecord{

	public $videoid;
	public $vid;

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'video_videoid';
    }

    public function gethotvideoid($max){
    	$o = $this->findAll();
        $todayhot=(int)strtotime(date ("Y-m-d H:i:s"))/(3600*24)%$max;
        return $o[$todayhot]['videoid'];
    }

    public function videoidtovid($videoid){
        $o = $this->find(
            array('condition'=>'videoid=:videoid',
            'params'=>array(':videoid'=>$videoid),));
        return $o['vid'];
    }

    public function relations()
    {
       return array(
            'vmsg'=>array(self::HAS_MANY, 'video_message', 'vid')
        
        );
    }

    public function attributeLabels()
    {
        return array(
            'vid' => 'vid',
            'videoid' => 'videoid',
        );
    }

}