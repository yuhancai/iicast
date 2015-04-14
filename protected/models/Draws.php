<?php

/**
 * This is the model class for table "tbl_draws".
 *
 * The followings are the available columns in table 'tbl_draws':
 * @property integer $id
 * @property integer $qishu
 * @property integer $luckynum
 * @property string $begin_at
 * @property string $lucky_at
 * @property string $open_at
 * @property integer $itemid
 */
class Draws extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $Bymins;
    public $DrawsWeight;
    public $itemname;
	public function tableName()
	{
		return 'tbl_draws';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qishu, luckynum, begin_at, lucky_at, open_at, itemid,itemname,bymins', 'required'),
			array('qishu, luckynum, itemid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, qishu, luckynum, begin_at, lucky_at, open_at, itemid, itemname,bymins', 'safe', 'on'=>'search'),
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
			'item'=>array(self::BELONGS_TO,'items','itemid')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'qishu' => 'Qishu',
			'luckynum' => 'Luckynum',
			'begin_at' => 'Begin At',
			'lucky_at' => 'Lucky At',
			'open_at' => 'Open At',
			'itemid' => 'Itemid',
		    'Bymins'=>'min',
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
		$criteria->compare('qishu',$this->qishu);
		$criteria->compare('luckynum',$this->luckynum);
		$criteria->compare('begin_at',$this->begin_at,true);
		$criteria->compare('lucky_at',$this->lucky_at,true);
		$criteria->compare('open_at',$this->open_at,true);
		$criteria->compare('itemid',$this->itemid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchCurrent()
	{
    	$criteria=new CDbCriteria;
    	
/*     	$criteria->with = array('item'=> array('alias'=>'i'));
    	$criteria->compare('id',$this->id);
    	$criteria->compare('qishu',$this->qishu);
    	$criteria->compare('luckynum',$this->luckynum);
    	$criteria->compare('begin_at',$this->begin_at,true);
    	$criteria->compare('lucky_at',$this->lucky_at,true);
    	$criteria->compare('open_at',$this->open_at,true);
    	$criteria->compare('itemid',$this->itemid);  */
    	
    	
   /*  	$criteria = new CDbCriteria;
    	// Classic method
    	$criteria->addCondition('t.id = :id');
    	$criteria->params = array(':id' => Yii::app()->user->id);
    	// Often used in search functions. Note: if passed value is empty, the WHERE is not added!
    	$criteria->compare('t.id', Yii::app()->user->id);
    	// This is my current favorite
    	$criteria->addColumnCondition(array('t.id' => Yii::app()->user->id));
    	// A bit weird here, but you can also do this
    	$criteria->addInCondition('t.id', array(Yii::app()->user->id)); */
    	
    	
    	/*      $criteria = new CDbCriteria();
    	 $criteria->with = array('tweTicketPriceLevels' => array('alias'=>'pl'));
    	 $criteria->condition = "(pl.start_timestamp - interval ':etz seconds') < (LOCALTIMESTAMP - interval ':stz seconds')";
    	 $criteria->addCondition("(pl.end_timestamp - interval ':etz seconds') >= (LOCALTIMESTAMP - interval ':stz seconds')");
    	 $criteria->addCondition('t.event_id = :eid');
    	 $criteria->addCondition('t.deleted IS NULL');
    	 $criteria->addCondition('pl.deleted IS NULL');
    	 $criteria->params = array(':etz' => (int)$etz, ':stz' => (int)$stz_offset, ':eid' => (int)$eid);
    	
    	 return self::model()->findAll($criteria); */
    	
    	$criteria->compare('itemid',$this->itemid);
    	$criteria->addColumnCondition(array('t.itemid' => $this->itemid));
    	$criteria->condition = "abs(strftime('%H',lucky_at)) >".date('H')." and abs(strftime('%H',begin_at))=10";
    	//$criteria->params = array(':selecthour' =>$selecthour);
    	return new CActiveDataProvider($this, array(
    	    'criteria'=>$criteria,
    	    'pagination'=>array(
    	        'pageSize'=>20,
    	    ),
    	   ));
	}
	public static function getMaxQishuByItemid($itemid)
	{
        $result= Yii::app()->db->createCommand()
        ->select('qishu')
        ->from('tbl_draws')
        ->where('itemid=:itemid', array(':itemid'=>$itemid))
        ->order('qishu desc')
        ->limit('1')
        ->queryAll();
		return $result[0]['qishu'];
	}	
	public static function itemidIsInDb($itemid)
	{
		$itemid=(int)$itemid;
        $result= Yii::app()->db->createCommand()
        ->select('*')
        ->from('tbl_draws')
        ->where('itemid=:itemid', array(':itemid'=>$itemid))
        ->queryAll();
		return (count($result)>0)?1:0;
	}
	public static function getDrawsByHour($itemid)
	{
	    $result= Yii::app()->db->createCommand()
	    ->select('*')
	    ->from('tbl_draws')
	    ->where('itemid=:itemid', array(':itemid'=>$itemid))
	    ->order('qishu desc')
	    ->limit('1')
	    ->queryAll();
	    return $result[0]['qishu'];
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Draws the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
