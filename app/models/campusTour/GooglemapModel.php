<?php
//the model of googlemap
class GooglemapModel extends CActiveRecord
{
	//create model
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	//set tablename
	public function tableName()
	{
		return 'campustour_googlemap';
	}
	//set function getGooglemap to get data from database
	public function getGooglemap()
	{
		$criteria=new CDbCriteria;
		$criteria->select='lat, lon, heading, zoom';
		$criteria->condition='name=:name';
		$criteria->params=array(':name'=>$this->name);
		return $this->find($criteria);
	}
	//set attrbuteLabels for the columns of table
	public function attributeLabels()
	{
		return array(
			'number' => 'the number of data',
			'name' => 'the name of place',
			'lat' => 'the latitude of place',
			'lon' => 'the longitude of place',
			'heading' => 'the rotation of view',
			'zoom' => 'the zoom magnification of view'
			);
	}
}

?>