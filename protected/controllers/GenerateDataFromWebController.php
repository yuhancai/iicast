<?php
include 'Getcontent.class.php';
class GenerateDataFromWebController extends Controller
{
	public function actionIndex()
	{
		$default_opts = array(
				'http'=>array(
						'method'=>"GET",
						'header'=>"Accept-language: en\r\n" .
						"Cookie: foo=bar",
						'proxy'=>"proxysv:80"
				)
		);
		$default = stream_context_set_default($default_opts);		
		$model=new GenerateDataForm();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);		
		$this->render('index',array(
				'model'=>$model,
		));
	}

	public function getDataFromUrl($url=null)
	{
	
		$content = file_get_contents($url);
		$obj = new Grep();
		$obj->set($content);
		$t = $obj->get('shijian', 0);
		$duobaotime=$t[1];
		$jieshutime=$t[2];
		$jiexiaotime=$t[0];
		$diji = $obj->get('dijiqi', 0);
		$pattern='/\d{1,}/';
		preg_match($pattern,$diji[0], $matches);
		$diji=$matches[0];
		$zhong = $obj->get('luckynum', 0)[0];
		$info=array(
				'duobaotime'=>$duobaotime,
				'jieshutime'=>$jieshutime,
				'jiexiaotime'=>$jiexiaotime,
				'diji'=>$diji,
				'zhong'=>$zhong
		);
		return $info;
	}
	 
	public function getAllDataFromUrl($url=null)
	{
		set_time_limit(0);
		$arrInfo=Model_Item::getInfoFromUrl($url);
		Model_Item::insertData($arrInfo[0]);//insert fromurl param into db or not
		$id=Model_item::getItemidFromForurl($arrInfo[0]);//get itemid
		if(Model_draw::itemidIsInDb($id)) $qishu=Model_draw::getMaxQishuByItemid($id);//get qishu id
		$qishu=(isset($qishu))?$qishu:1;
		$total=(int)$arrInfo[1];
		if($qishu<$total)
		{
			for($s=$qishu;$s<=$total;$s++)
			{
			$str="http://1.163.com/detail/";
					$str.=$arrInfo[0];
					switch (strlen((string)$s))
					{
					case 1: $str.="-00-00-0".$s.".html";break;
					case 2: $str.="-00-00-".$s.".html"; break;
							case 3: $str.="-00-0".substr($s,0,1)."-".substr($s,-2).".html";break;
							case 4: $str.="-00-".substr($s,0,2)."-".substr($s,-2).".html";break;
							case 5: $str.="-0".substr($s,0,1)."-".substr($s,1,2)."-".substr($s,-2).".html";break;
									case 6: $str.="-".substr($s,0,2)."-".substr($s,2,2)."-".substr($s,4).".html";break;
									default: break;
					}
					$jieshu[]=$this->getDataFromUrl($str)['jieshutime'];
					$fromOnepage=$this->getDataFromUrl($str);
					if($s>=$qishu+1)
					{
					$allData[]=array(
					"qishu"=>$fromOnepage['diji'],
					"luckynum"=>$fromOnepage['zhong'],
					"begin_at"=>$jieshu[$s-$qishu-1],
					"lucky_at"=>$fromOnepage['duobaotime'],
							"open_at"=>$fromOnepage['jieshutime'],
							//"jiexiaotime"=>$fromOnepage['jiexiaotime'],
									'itemid' => $id
							);
									$draw = Model_Draw::forge($allData[$s-$qishu-1]);
									if($draw and $draw->save())
									continue;
					}
					$ar[]=$str;
					}
					}
					return isset($allData)?$allData:false;
			}
			 
	
	
			/*
			*
			*    	$arrInfo=Model_Item::getInfoFromUrl($url);
			$total=(int)$arrInfo[1];
			for($s=1;$s<=$total;$s++)
			{
			$str="http://1.163.com/detail/";
			$str.=$arrInfo[0];
			switch (strlen((string)$s))
			{
			case 1: $str.="-00-00-0".$s.".html";break;
			case 2: $str.="-00-00-".$s.".html"; break;
			case 3: $str.="-00-0".substr($s,0,1)."-".substr($s,-2).".html";break;
			case 4: $str.="-00-".substr($s,0,2)."-".substr($s,-2).".html";break;
			case 5: $str.="-0".substr($s,0,1)."-".substr($s,1,2)."-".substr($s,-2).".html";break;
			case 6: $str.="-".substr($s,0,2)."-".substr($s,2,2)."-".substr($s,4).".html";break;
			default: break;
			}
			$jieshu[]=$this->getDataFromUrl($str)['jieshutime'];
			$fromOnepage=$this->getDataFromUrl($str);
			if($s>1)
			{
			$allData[]=array("kaishitime"=>$jieshu[$s-2],"duobaotime"=>$fromOnepage['duobaotime'],"jieshutime"=>$fromOnepage['jieshutime'],"jiexiaotime"=>$fromOnepage['jiexiaotime'],"diji"=>$fromOnepage['diji'],"zhong"=>$fromOnepage['zhong']);
			}
			$ar[]=$str;
			}
			return $allData;
			/////$arrInfo=Model_Item::getInfoFromUrl($url);
			$id=Model_item::getItemidFromForurl($arrInfo[0]);
			$drawid=Model_draw::getMaxQishuByItemid($id);
			$drawid=($drawid)?$drawid:1;
			 
			$total=(int)$arrInfo[1];
			for($s=$drawid;$s<=$total;$s++)
			{
			$str="http://1.163.com/detail/";
			$str.=$arrInfo[0];
			switch (strlen((string)$s))
			{
			case 1: $str.="-00-00-0".$s.".html";break;
			case 2: $str.="-00-00-".$s.".html"; break;
			case 3: $str.="-00-0".substr($s,0,1)."-".substr($s,-2).".html";break;
			case 4: $str.="-00-".substr($s,0,2)."-".substr($s,-2).".html";break;
			case 5: $str.="-0".substr($s,0,1)."-".substr($s,1,2)."-".substr($s,-2).".html";break;
			case 6: $str.="-".substr($s,0,2)."-".substr($s,2,2)."-".substr($s,4).".html";break;
			default: break;
			}
			$jieshu[]=$this->getDataFromUrl($str)['jieshutime'];
			$fromOnepage=$this->getDataFromUrl($str);
			if($s>=$drawid+1)
			{
			$allData[]=array("kaishitime"=>$jieshu[$s-$drawid-1],"duobaotime"=>$fromOnepage['duobaotime'],"jieshutime"=>$fromOnepage['jieshutime'],"jiexiaotime"=>$fromOnepage['jiexiaotime'],"diji"=>$fromOnepage['diji'],"zhong"=>$fromOnepage['zhong']);
			}
			$ar[]=$str;
			}
			return $allData;
			 
			 
			*/
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}