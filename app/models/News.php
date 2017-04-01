<?php

/**
 * This is the model class for table "general_news".
 *
 * The followings are the available columns in table 'general_news':
 * @property integer $id
 * @property string $auth_id
 * @property string $post_time
 * @property integer $views
 * @property string $title
 * @property string $content
 * @property string $to_top
 * @property string $visable
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'general_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('auth_id, post_time, views, title, content', 'required'),
			array('views', 'numerical', 'integerOnly'=>true),
			array('auth_id', 'length', 'max'=>32),
			array('title', 'length', 'max'=>30),
			array('to_top, visable', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, auth_id, post_time, views, title, content, to_top, visable', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'auth' => array(self::BELONGS_TO,'GeneralUserProfile',array('auth_id'=>'uid'))
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'auth_id' => 'Auth',
			'post_time' => 'Post Time',
			'views' => 'Views',
			'title' => 'Title',
			'content' => 'Content',
			'to_top' => 'To Top',
			'visable' => 'Visable',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('auth_id',$this->auth_id,true);
		$criteria->compare('post_time',$this->post_time,true);
		$criteria->compare('views',$this->views);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('to_top',$this->to_top,true);
		$criteria->compare('visable',$this->visable,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}