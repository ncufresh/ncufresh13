<?php

/**
 * This is the model class for table "game_shop_style".
 *
 * The followings are the available columns in table 'game_shop_style':
 * @property integer $pid
 * @property integer $sid
 * @property integer $cost
 * @property integer $type
 * @property string $name
 * @property string $message
 * @property integer $src_x
 * @property integer $src_y
 * @property integer $part_width
 * @property integer $part_height
 */
class GameShopStyle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GameShopStyle the static model class
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
		return 'game_shop_style';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, cost, type, name, message, src_x, src_y, part_width, part_height', 'required'),
			array('sid, cost, type, src_x, src_y, part_width, part_height', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pid, sid, cost, type, name, message, src_x, src_y, part_width, part_height', 'safe', 'on'=>'search'),
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
			'posts'=>array(self::HAS_ONE, 'DressModel', 'sid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pid' => 'Pid',
			'sid' => 'Sid',
			'cost' => 'Cost',
			'type' => 'Type',
			'name' => 'Name',
			'message' => 'Message',
			'src_x' => 'Src X',
			'src_y' => 'Src Y',
			'part_width' => 'Part Width',
			'part_height' => 'Part Height',
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

		$criteria->compare('pid',$this->pid);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('src_x',$this->src_x);
		$criteria->compare('src_y',$this->src_y);
		$criteria->compare('part_width',$this->part_width);
		$criteria->compare('part_height',$this->part_height);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}