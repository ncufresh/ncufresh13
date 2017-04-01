<?php
	class Html extends CHtml{
		public static function createAjax($controller){
			return CHtml::ajaxButton ("",
									$controller->createUrl('CampusLife/AjaxDynamicView'), 
									array(
										'success' => 'js:function(html){
											$("#panel").html(html);
										}'));;
		}

		public static function headImgButton($name,$currentController,$content=''){//$name為要產生的img名稱
			$bUrl=Yii::app()->request->baseUrl;
			$imgPath=$bUrl.'/file'.'/'.'img'.'/'.'head'.'/'.$name;
			$imgPath.=($name==$currentController)?'On.gif':'Btn.gif';
			if($content!=''){
				shuffle($content);
				$marquee='<ul class="head_ul">';
				foreach ($content as $text) {
					$marquee.='<li>'.$text.'</li>';
				}
				$marquee.='</ul>';
			}else{
				$marquee='';
			}
			$imgtag=CHtml::tag('img',array(
					'src' =>$imgPath,
					'style'=>'height:70px;width:250px;border-style:none;'
				),'',false);
			$link=CHtml::tag('a',array(
					'href'=>$bUrl.'/'.$name.'/index.html'
				),$marquee.$imgtag,true);
			$div='<div style="position: relative;float:left;">'.$link.'</div>';
			return $div;
		}

		public static function blockHead($id='',$display='none',$closeable=false){
			$bUrl=Yii::app()->request->baseUrl;
			$controllerName=Yii::app()->controller->id;
			$head=
			CHtml::tag('div',array(
					'class'	=>'cnt_warpped',
					'id'	=>$id.'_warpped',
					'style'	=>'display:'.$display.';border-style:none;'

				),
			'',false).
			(($closeable)?
			CHtml::tag('div',array(
					'class'	=>'close',
					'id'	=>$id.'_close',
					'style'	=>'display:'.$display.';',
					'onClick'=>'animateClose("'.$id.'")'
				),
			'<img src="'.$bUrl.'/file/img/close.png" >',true):'').
			CHtml::tag('div',array(
					'class' =>'flag'
				),
			($controllerName=="site")?'':'<img src="'.$bUrl.'/file/img/flag/'.Yii::app()->controller->id.'Flag.gif" style="border-style:none;">'
			,true).
			CHtml::tag('div',array(
					'class'	=>'cnt_head',
					'id'	=>$id.'_head',
				),
			'',true).
			CHtml::tag('div',array(
					'class'	=>'cnt_body',
					'id'	=>$id.'_body',
				),
			'',false);
			return $head;
		}

		public static function blockBottom($id='',$display='none',$closeable=false){
			$bUrl=Yii::app()->request->baseUrl;
			$bottom=
			CHtml::closeTag('div').
			CHtml::tag('div',array(
					'class'	=>'cnt_btm',
					'id'	=>$id.'_btm',
				),
			'',true).
			CHtml::closeTag('div');
			return $bottom;
		}

		public static function getPersonalImgUrl($uid){
			$connection = Yii::app()->db;

			$sql = "SELECT `general_user_profile`.`skin_id`
					FROM `general_user_profile`
					WHERE `general_user_profile`.`uid` = :uid";

			$command = $connection->createCommand($sql);

			$command->bindParam(":uid", $uid, PDO::PARAM_STR);
			$row = $command->queryRow();
			$bUrl = Yii::app()->request->baseUrl;
			$url = $bUrl.'/file/img/personal/'.$row['skin_id'].'.gif';
			return $url;
		}

		public static function getPersonalImgWUrl($uid){
			$connection = Yii::app()->db;

			$sql = "SELECT `general_user_profile`.`skin_id`
					FROM `general_user_profile`
					WHERE `general_user_profile`.`uid` = :uid";

			$command = $connection->createCommand($sql);

			$command->bindParam(":uid", $uid, PDO::PARAM_STR);
			$row = $command->queryRow();
			$bUrl = Yii::app()->request->baseUrl;
			$url = $bUrl.'/file/img/person_w/'.$row['skin_id'].'w.gif';
			return $url;
		}
	}