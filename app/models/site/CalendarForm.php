<?php

class CalendarForm extends CActiveRecord
{
    	public static function model($className=__CLASS__)
    	{
			return parent::model($className);
    	}
    	public function tableName()
    	{
			return 'calendar';
    	}

    	public function getLength(){
    	//讓日曆出現在這星期的頁面上，datecontent的全長度
    		
			$range = time()-strtotime('2013-08-04 00:00:00') ;
			// $range = strtotime('2013-09-10 00:00:01')-strtotime('2013-08-04 00:00:01') ;
			//for test測試用------------------------>
			if( $range<0 ){
				$length=0 ;
			}
			else if( $range>=0 && $range<=(strtotime('2014-02-01 00:00:00')-strtotime('2013-08-04 00:00:01')) ){
				$passDay = $range / (86400*7) ;
				$length = (-427) * floor($passDay) ;//取整數值
				// $length = (-$frameWidth) * floor($passDay) ;
			}
			else if( $range>(strtotime('2014-02-01 00:00:00')-strtotime('2013-08-04 00:00:01')) ){
				$length=-11025;
			}

			return $length ;
    	}

    	public function getResentEvent($first_day, $final_day, $event){
    		$today = time() ;
    		// $today = strtotime('2013-09-10 00:00:01') ;
    		//for test測試用------------------------>
    		$eventNumber =0;
    		$todayEvent=null;
    		$eventID=null;

  			for ( $a=0 ; $a<count($event) ; $a++ ){
    			if ( ($today>=strtotime($first_day[$a])) && ($today<=(strtotime($final_day[$a])+86399)) ){
    				$todayEvent[$eventNumber] = $event[$a] ;
    				$eventID[$eventNumber] = $a ;
    				$eventNumber++ ;
    			}
    		}
    		return array($todayEvent, $eventNumber, $eventID ) ;
    	}

    	public function getAllMessage($firstday, $finalday){
    		//獲得事件紅外框的所有元素
			
			$today = time() ;
    		// $today = strtotime('2013-09-10 00:00:01') ;
    		//for test測試用------------------------>

    		$standard = strtotime('2013-08-04') ;
			$year=2013 ;
			for( $a=0 ; $a<18 ; $a++ ){
				// if($a==14){//若到了2014年
				// 	$year++ ;
				// }
				$leftlength[$a] = ((strtotime($year.'/'.$firstday[$a])-$standard)/86400)*61 ;
				$rightlength[$a] = ((strtotime($year.'/'.$finalday[$a])-$standard)/86400+1)*61 ;
				$width[$a] = $rightlength[$a]-$leftlength[$a]-10 ;
			}

			$point[0]="" ;
			$point[1]="" ;
			$point[2]="" ;
			$point[3]="" ;
			$point[4]="" ;
			$point[5]="" ;
			$point[6]="" ;
			$point[7]="繳交時間9/10~9/14" ;
			$point[8]="" ;
			$point[9]="" ;
			$point[10]="心理適應講座" ;
			$point[11]="UCAN職業興趣測驗" ;
			$point[12]="校園安全講習" ;
			$point[13]="僑生外籍生中文測驗" ;
			$point[14]="" ;
			$point[15]="" ;
			$point[16]="";
			$point[17]="";

			$document[0]="RelationView" ;
			$document[1]="FreshmanView" ;
			$document[2]="FreshmanView" ;
			$document[3]="";
			$document[4]="FreshmanView" ;
			$document[5]="RelationView" ;
			$document[6]="ActiveView" ;
			$document[7]="RelationView" ;
			$document[8]="" ;
			$document[9]="FreshmanView" ;
			$document[10]="FreshmanView";
			$document[11]="FreshmanView";
			$document[12]="RelationView" ;
			$document[13]="FreshmanView" ;
			$document[14]="RelationView" ;
			$document[15]="FreshmanView" ;
			$document[16]="FreshmanView" ;
			$document[17]="" ;

			$filename[0]="rel_1" ;
			$filename[1]="fre_8" ;
			$filename[2]="fre_7" ;
			$filename[3]="" ;
			$filename[4]="fre_8" ;
			$filename[5]="rel_1" ;
			$filename[6]="act_4" ;
			$filename[7]="rel_3" ;
			$filename[8]="" ;
			$filename[9]="fre_3" ;
			$filename[10]="fre_2";
			$filename[11]="fre_1";
			$filename[12]="rel_7";
			$filename[13]="fre_5";
			$filename[14]="rel_3" ;
			$filename[15]="fre_8" ;
			$filename[16]="fre_8" ;
			$filename[17]="" ;

			return array($width, $leftlength, $rightlength, $point, $document, $filename) ;
    	}
}




?>