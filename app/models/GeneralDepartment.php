<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/17
 * Time: 下午 10:34
 */

/**
 * This is the model class for table "general_department".
 *
 * The followings are the available columns in table 'general_department':
 * @property integer $department_id
 * @property string $department_name
 *
 * The followings are the available model relations:
 * @property GeneralUserProfile[] $generalUserProfiles
 */
class GeneralDepartment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeneralDepartment the static model class
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
		return 'general_department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('department_id, department_name', 'required'),
			array('department_id', 'numerical', 'integerOnly'=>true),
			array('department_id, department_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'generalUserProfiles' => array(self::HAS_MANY, 'GeneralUserProfile', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'department_id'  => 'Department',
			'department_name'=> 'Department Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('department_name',$this->department_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

/*
CREATE TABLE IF NOT EXISTS `general_department` (
  `department_id` int(11) NOT NULL,
  `department_name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ncufresh13_test`.`general_department` (`department_id`, `department_name`) VALUES ('11', '中文系'), ('52', '資工系');
 */