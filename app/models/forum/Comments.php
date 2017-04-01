<?php

/**
 * This is the model class for table "2013_comment".
 *
 * The followings are the available columns in table '2013_comment':
 * @property integer $id
 * @property integer $article_id
 * @property integer $auth_id
 * @property string $content
 * @property string $post_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Article $article
 * @property User $auth
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return 'forum_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required', 'message'=>'請輸入回覆內容'),
			array('article_id', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'min'=>4, 'max'=>512, 'tooShort'=>'回覆最短要4字元', 'tooLong'=>'回覆最長為512字元'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('post_time', 'date', 'format'=>'yyyy-M-d H:m:s'),
			array('id, article_id, auth_id, content, post_time, update_time', 'safe', 'on'=>'search'),
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
			'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
			'auth' => array(self::BELONGS_TO, 'GeneralUserProfile', array('auth_id'=>'uid')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'article_id' => 'Article',
			'auth_id' => 'Auth',
			'content' => 'Content',
			'post_time' => 'Post Time',
			'update_time' => 'Update Time',
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord)
        	$this->post_time = new CDbExpression('NOW()');
    	else
        	$this->update_time = new CDbExpression('NOW()');
        return parent::beforeSave();
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
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('auth_id',$this->auth_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('post_time',$this->post_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function setArticleId($id=0)
	{
		$this->article_id=$id;
	}
}