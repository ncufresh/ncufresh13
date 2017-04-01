<?php

class ImageModel extends CFormModel 
{
	public $image;
	public $e_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CFormModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('image', 'file', 'types'=>'jpg, gif, png', 'maxSize'=>1024 * 1024,'tooLarge'=>'檔案必需小於1mb'),
			// array('e_name', 'exist','attributeName'=>'e_name','className')
		);
	}


	/**
	 * @return array customized attribute labels (name=&gt;label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
}
