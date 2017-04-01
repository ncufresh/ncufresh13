<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $id
 * @property integer $auth_id
 * @property integer $sort_id
 * @property string $post_time
 * @property string $update_time
 * @property integer $views
 * @property string $title
 * @property string $content
 *
 * The followings are the available model relations:
 * @property 2013Comment[] $2013Comments
 * @property User $auth
 * @property SortTag $sort
 */
class Article extends CActiveRecord
{
	public $update_views;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'forum_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('auth_id, title', 'required', 'message'=>'請輸入標題'),
			array('content', 'required', 'message'=>'請輸入文章內容'),
			array('sort_id, views', 'numerical', 'integerOnly'=>true, 'message'=>'請輸入內容'),
			array('title', 'titleCheck'),
			array('content', 'length', 'min'=>10, 'max'=>512, 'tooShort'=>'文章最短要10字元', 'tooLong'=>'文章最長為512字元'),
			array('sort_id', 'checkIsExistSort'),
			array('post_time', 'date', 'format'=>'yyyy-M-d H:m:s'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, auth_id, sort_id, post_time, update_time, views, title, content', 'safe', 'on'=>'search'),
		);
	}

	public function titleCheck()
	{
		if(mb_strlen($this->title, 'UTF-8')<2)
			$this->addError('錯誤', '標題最少要2字');
		else if(mb_strlen($this->title, 'UTF-8')>12)
			$this->addError('錯誤', '標題最長為12字');
	}

	public function checkIsExistSort()
	{
		if(!SortTag::model()->exists("id=?",array($this->sort_id)))
			$this->addError('參數錯誤', '請選擇分類');
	}

	public function beforeDelete()
    {
        $idCache = $this->id;
        $criteria = new CDbCriteria(array(
                'condition' => 'article_id=:parentId',	
                'params' => array(
                    ':parentId' => $idCache),
            ));

        $children = Comments::model()->findAll($criteria);

        foreach ($children as $child)
        {
            $child->delete();
        }
        return parent::beforeDelete();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comments', 'article_id'),
			'auth' => array(self::BELONGS_TO, 'GeneralUserProfile', array('auth_id'=>'uid')),
			'sort' => array(self::BELONGS_TO, 'SortTag', 'sort_id'),
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
			'sort_id' => 'Sort',
			'post_time' => 'Post Time',
			'update_time' => 'Update Time',
			'views' => 'Views',
			'title' => 'Title',
			'content' => 'Content',
			'to_top' => 'TopArticle',
		);
	}

	public function beforeSave()
	{

		if ($this->isNewRecord)
        	$this->post_time = new CDbExpression('NOW()');
    	else if(!$this->update_views)
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
		$criteria->compare('auth_id',$this->auth_id);
		$criteria->compare('sort_id',$this->sort_id);
		$criteria->compare('post_time',$this->post_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('views',$this->views);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getHottestArticle()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.views DESC, t.post_time DESC',
			'limit'=>11	,
		));
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
		$rtn = array();
		foreach ($dataProvider->getData() as $key) {
			if(mb_strlen($key->title,'UTF-8')>7){
				$t['title'] = mb_substr($key->title,0,7,'UTF-8').'...';
			}else{
				$t['title'] = $key->title;
			}
			$t['sortTag'] = $key->sort->name;
			$t['postTime'] = $key->post_time;
			$t['url'] = Yii::app()->createUrl('forum/index', array('id'=>$key->id));
			array_push($rtn, $t);
		}
		return $rtn;
	}

	public function getNewestArticle()
	{
		$criteria=new CDbCriteria(array(
			'select'=>"t.*",
			'join'=>'LEFT JOIN forum_comment c ON t.id=c.article_id',
			'group'=>'t.id',
			'order'=>'t.post_time DESC, c.post_time DESC',
			'limit'=>11,
		));
		// $criteria->group='t.id';
		$dataProvider=new CActiveDataProvider(Article::model(), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));	
		$rtn = array();
		foreach ($dataProvider->getData() as $key) {
			if(mb_strlen($key->title, 'UTF-8')>7){
				$t['title'] = mb_substr($key->title,0,7,'UTF-8').'...';
			}else{
				$t['title'] = $key->title;
			}
			$t['sortTag'] = $key->sort->name;
			$t['postTime'] = $key->post_time;
			$t['url'] = Yii::app()->createUrl('forum/index', array('id'=>$key->id));
			array_push($rtn, $t);
		}
		return $rtn;
	}
	
}