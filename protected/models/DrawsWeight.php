<?php
class DrawsWeight extends CActiveRecord 
{
  
     //called on rendering the column for each row 
     public function renderWeight($data,$row)
     {
        $rows=Draws::model()->findAllByAttributes(array('itemid'=>$data->id));
        $result = '';
        foreach ($rows as $row)
        {
            $result.=$row->qishu;
        }
	    return $result;
    }       
 
}
?>