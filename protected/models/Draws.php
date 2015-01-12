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
			array('qishu, luckynum, begin_at, lucky_at, open_at, itemid', 'required'),
			array('qishu, luckynum, itemid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, qishu, luckynum, begin_at, lucky_at, open_at, itemid', 'safe', 'on'=>'search'),
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
	public static function caculateDiffByMinutes($start,$end)
	{
		$datetime1 = strtotime($start);
		$datetime2 = strtotime($end);
		$interval  = abs($datetime2 - $datetime1);
		$minutes   = round($interval / 60);
		return $minutes;
	}
	public static function caculateWeight($a,$w)
    {
        $b=array();
        $c=count($a);
    	for($i=0;$i<$c-$w+1;$i++)
    	{
    		$t=0;
    		for($j=$i;$j<$w+$i;$j++)
    		{
    		$t+=$a[$j];		
    		}
    		$t=round($t/$w);
    		$b[]=$t;
            $t=0;		
    	}
    	return $b;
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
