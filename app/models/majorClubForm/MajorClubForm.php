<?php

/**
 * This is the model class for table "club_intro".
 *
 * The followings are the available columns in table 'club_intro':
 * @property integer $id
 * @property integer $catalog
 * @property integer $catalogdetal
 * @property string $c_name
 * @property string $e_name
 * @property string $intro
 * @property string $fb
 * @property string $contact1_name
 * @property string $contact1_fb
 * @property string $contact1_email
 * @property string $contact2_name
 * @property string $contact2_fb
 * @property string $contact2_email
 * @property string $img
 */
class MajorClubForm extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ClubIntro the static model class
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
        return 'club_intro';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('catalog, catalogdetal, c_name, e_name', 'required'),
            array('catalog, catalogdetal', 'numerical', 'integerOnly'=>true),
            array('c_name, e_name, contact1_name, contact2_name', 'length', 'max'=>15),
            array('fb, contact1_fb, contact2_fb', 'length', 'max'=>80),
            array('contact1_email, contact2_email', 'length', 'max'=>30),
            array('img', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, catalog, catalogdetal, c_name, e_name, intro, fb, contact1_name, contact1_fb, contact1_email, contact2_name, contact2_fb, contact2_email, img', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'catalog' => 'Catalog',
            'catalogdetal' => 'Catalogdetal',
            'c_name' => 'C Name',
            'e_name' => 'E Name',
            'intro' => 'intro',
            'fb' => 'fb',
            'contact1_name' => 'contact1_name',
            'contact1_fb' => 'contact1_fb',
            'contact1_email' => 'contact1_email',
            'contact2_name' => 'contact2_name',
            'contact2_fb' => 'contact2_fb',
            'contact2_email' => 'contact2_email',
            'img' => 'Img',
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
        $criteria->compare('catalog',$this->catalog);
        $criteria->compare('catalogdetal',$this->catalogdetal);
        $criteria->compare('c_name',$this->c_name,true);
        $criteria->compare('e_name',$this->e_name,true);
        $criteria->compare('intro',$this->intro,true);
        $criteria->compare('fb',$this->fb,true);
        $criteria->compare('contact1_name',$this->contact1_name,true);
        $criteria->compare('contact1_fb',$this->contact1_fb,true);
        $criteria->compare('contact1_email',$this->contact1_email,true);
        $criteria->compare('contact2_name',$this->contact2_name,true);
        $criteria->compare('contact2_fb',$this->contact2_fb,true);
        $criteria->compare('contact2_email',$this->contact2_email,true);
        $criteria->compare('img',$this->img,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}