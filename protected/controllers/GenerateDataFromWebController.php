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
//print_r($this->getDataFromUrl("http://1.163.com/detail/01-48-00-07-53.html"));
		
		print_r($this->getAllDataFromUrl("http://1.163.com/detail/01-48-00-08-33.html"));
		
		
		
		
		
		
		
		
		
		
		
		
/* 		http://1.163.com/detail/01-37-00-19-31.html
		http://1.163.com/detail/01-16-00-14-00.html
		
		http://1.163.com/detail/01-48-00-08-33.html  iPhone6 4.7英寸 64G
		http://1.163.com/detail/01-77-00-05-20.html  iPhone6 Plus 5.5英寸 64G
		http://1.163.com/detail/01-45-00-02-28.html   iPad Air 2 16G WIFI版
		http://1.163.com/detail/00-95-00-00-44.html  HTC One （E8）时尚版 4G手机
		http://1.163.com/detail/00-80-00-04-14.html  MacBook Air 13.3
		http://1.163.com/detail/00-79-00-00-95.html  MacBook Air 11.6
		http://1.163.com/detail/01-21-00-00-44.html  苹果Mac mini MD387CH/A
		http://1.163.com/detail/01-68-00-01-66.html  漫步者 R10U 2.0声道
		http://1.163.com/detail/00-50-00-01-00.html
		http://1.163.com/detail/00-49-00-00-55.html
		http://1.163.com/detail/00-74-00-01-58.html
		http://1.163.com/detail/01-59-00-01-06.html
		
		http://1.163.com/detail/01-00-00-00-09.html
		http://1.163.com/detail/00-43-00-01-49.html
		http://1.163.com/detail/00-44-00-00-92.html
		http://1.163.com/detail/01-40-00-00-17.html
		http://1.163.com/detail/01-19-00-03-24.html
		http://1.163.com/detail/01-76-00-00-40.html
		http://1.163.com/detail/02-11-00-00-02.html
		http://1.163.com/detail/02-01-00-00-50.html
		http://1.163.com/detail/02-21-00-00-09.html
		http://1.163.com/detail/01-96-00-00-05.html
		http://1.163.com/detail/02-17-00-00-16.html
		http://1.163.com/detail/01-39-00-00-20.html
		http://1.163.com/detail/01-38-00-00-30.html */
		
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
		$diji = $obj->get('dijiqi', 0)[0];
		//$pattern='/\d{1,}/';
		//preg_match($pattern,$diji[0], $matches);
		//$diji=$matches[0];
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
		$arrInfo=Util::getInfoFromUrl($url);
		Items::insertData($arrInfo[0]);//insert fromurl param into db or not
		$id=Items::getItemidFromForurl($arrInfo[0]);//get itemid
		if(Draws::itemidIsInDb($id)) $qishu=Draws::getMaxQishuByItemid($id);//get qishu id
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
					$model=new Draws;
					$model->attributes=$allData[$s-$qishu-1];
					$model->save();
								/* 
								 * // an SQL with two placeholders ":username" and ":email"
$sql="INSERT INTO tbl_user (username, email) VALUES(:username,:email)";
$command=$connection->createCommand($sql);
// replace the placeholder ":username" with the actual username value
$command->bindParam(":username",$username,PDO::PARAM_STR);
// replace the placeholder ":email" with the actual email value
$command->bindParam(":email",$email,PDO::PARAM_STR);
$command->execute();
// insert another row with a new set of parameters
$command->bindParam(":username",$username2,PDO::PARAM_STR);
$command->bindParam(":email",$email2,PDO::PARAM_STR);
$command->execute();
								 * 
								 * 	$draw = draws::forge($allData[$s-$qishu-1]);
									if($draw and $draw->save())
									continue; */
					}
					$ar[]=$str;
					}
			}
					return isset($allData)?$allData:false;
	}
			 
	
	
			/*
			*
			*    	$arrInfo=Util::getInfoFromUrl($url);
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
			/////$arrInfo=Util::getInfoFromUrl($url);
			$id=items::getItemidFromForurl($arrInfo[0]);
			$drawid=draws::getMaxQishuByItemid($id);
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