<?php
/**
 * Util class
 *
 * This class contains some tools for caculating *
 * 
 * @author hancai.yu<firstphpman@gmail.com>
 * @version 1.0.0
 */
class Util
{
    /**
     * Caculate the Weight
     * @param array $a the source array
     * @param integer $w the weight element
     * @return array $b the new Array after weighting
     */
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
     * Caculate the time between to datetime by minutes
     * @param datetime $start 
     * @param datetime $end
     * @return integer $minutes
     */
    public static function caculateDiffByMinutes($start,$end)
    {
        $datetime1 = strtotime($start);
        $datetime2 = strtotime($end);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        return $minutes;
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
}