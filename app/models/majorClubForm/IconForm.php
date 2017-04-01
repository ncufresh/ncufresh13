<?php

/* this model is about all the icon data.*/
/*
-----information-----
	table name : majorclub_icon
	column : {'icon_id'[int(11)],
			'name'[varchar(20)],
			'name_chinese'[text],
			'img'[text]
			}

*/

class IconForm extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'majorclub_name';
	}
}

?>