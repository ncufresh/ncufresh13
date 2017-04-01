<?php

/**
 * This is the model class for table "general_user_profile".
 *
 * The followings are the available columns in table 'general_user_profile':
 * @property integer $uid
 * @property string $name
 * @property string $sex
 * @property string $nickname
 * @property integer $department_id
 * @property integer $grade
 * @property string $high_school
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property Department $department
 */
class GeneralUserProfile extends CActiveRecord
{
	public $repassword;
	public $_identity;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeneralUserProfile the static model class
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
		return 'general_user_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{	$shortMessage='{attribute}長度必需大於{min}個字';
		$lengthMessage='{attribute}長度必需介於{min}到{max}個字之間';
		$longMessage='{attribute}長度必需小於{max}個字';
		return array(
 			array('username, repassword, password, name, sex, nickname, department_id, grade, high_school, birthday', 'required','message'=>'{attribute}一定要填','on'=>'register'),
 			array('username','email','message'=>'email格式不合法','on'=>'register'),
 			array('username','unique','message'=>'此帳號已有人使用'),
 			array('password','length','min'=>6,'max'=>20, 'tooShort'=>$shortMessage,'tooLong'=>$longMessage,'message'=>$lengthMessage),
 			array('name,nickname', 'length', 'min'=>2, 'max'=>10, 'tooShort'=>$shortMessage,'tooLong'=>$longMessage,'message'=>$lengthMessage),
			array('high_school', 'length','min'=>2, 'max'=>25, 'tooShort'=>$shortMessage,'tooLong'=>$longMessage,'message'=>$lengthMessage),
 			array('repassword','compare','compareAttribute'=>'password','message'=>'兩次密碼輸入不同','on'=>'register','operator'=>'==','allowEmpty'=>false),
 			array('repassword','safe','on'=>'register'),
			array('sex','in','range'=>array('f','m'),'allowEmpty'=>false),
			array('department_id', 'exist', 'attributeName'=>'department_id', 'className'=>'GeneralDepartment'),
			array('department_id', 'numerical', 'integerOnly'=>true),
			array('grade','in','range'=>array('一','二','三','四'),'allowEmpty'=>'true'),	
			array('birthday','date','format'=>'yyyy-MM-dd','allowEmpty'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, name, nickname, department_id, grade, high_school, birthday', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'department' => array(self::BELONGS_TO, 'GeneralDepartment', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            => 'ID',
			'uid'           => 'Uid',
			'username'      => '帳號',
			'password'      => '密碼',
			'repassword'    => '再輸入一次密碼',
			'name'          => '姓名',
			'sex'           => '性別',
			'nickname'      => '綽號',
			'fb'            => 'Facebook',
			'department_id' => '系所',
			'grade'         => '年級',
			'high_school'   => '畢業高中',
			'birthday'      => '生日',
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

 		$criteria->compare('uid',$this->uid,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('sex',$this->sex,true);
        $criteria->compare('nickname',$this->nickname,true);
        $criteria->compare('fb',$this->fb,true);
        $criteria->compare('department_id',$this->department_id);
        $criteria->compare('grade',$this->grade,true);
        $criteria->compare('high_school',$this->high_school,true);
        $criteria->compare('birthday',$this->birthday,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
			$this->password=self::md5pw($this->password);
			$this->repassword=self::md5pw($this->repassword);

			$this->uid=md5($this->username);
			return parent::beforeSave();
	}
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,self::md5pw($this->password));
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration = 3600 * 24 * 7;
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	public function departmentIdArray(){
		$array=GeneralDepartment::model()->findAll();
		return $array;
	}
	public static function md5pw($id){
			return md5($id.'wja2@wi'.md5($id));
		}

}
