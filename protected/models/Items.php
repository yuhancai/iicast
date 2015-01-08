<?php

/**
 * This is the model class for table "tbl_items".
 *
 * The followings are the available columns in table 'tbl_items':
 * @property integer $id
 * @property string $itemname
 * @property integer $itemtype
 * @property string $itemabbr
 * @property string $forurl
 */
class Items extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, forurl', 'required'),
			array('itemtype', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>200),
			array('itemabbr', 'length', 'max'=>100),
			array('forurl', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, itemname, itemtype, itemabbr, forurl', 'safe', 'on'=>'search'),
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
			'itemname' => 'Itemname',
			'itemtype' => 'Itemtype',
			'itemabbr' => 'Itemabbr',
			'forurl' => 'Forurl',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('itemtype',$this->itemtype);
		$criteria->compare('itemabbr',$this->itemabbr,true);
		$criteria->compare('forurl',$this->forurl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function isInDb($fromurl)
	{
	    $fromurl=(string)$fromurl;
        $result= Yii::app()->db->createCommand()
        ->select('itemname')
        ->from('tbl_items')
        ->where('forurl=:fl', array(':fl'=>$fromurl))
        ->queryAll();
        return (count($result)>0)?1:0;
	}
	
	public static function insertData($fromurl)
	{
	 if(!Items::isInDb($fromurl))
	 {
	     $result= Yii::app()->db->createCommand()
         ->insert('tbl_items', array(
            'itemname' =>'joly1',
            'forurl'=>$fromurl,
          ))
	     ->execute();	     
     }
	 else
	 {
	 	//doing nothing
	 }
    }   
    public static function getInfoFromUrl($url)
    {
    	$pattern='/\d{2}-\d{2}-\d{2}-\d{2}-\d{2}/';
    	preg_match($pattern,$url, $matches);
    	$d=implode(explode('-',$matches[0]));
    	$a=array();
    	$a[]=substr($matches[0],0,5);//for itemtype
    	$a[]=substr($d,4);//for loops
    	return $a;     	
    }
    
    public static function getItemidFromForurl($fromurl)
    {
        $result= Yii::app()->db->createCommand()
        ->select('id')
        ->from('tbl_items')
        ->where('forurl=:fl', array(':fl'=>$fromurl))
        ->queryAll();
        return $result[0]['id'];
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Items the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
