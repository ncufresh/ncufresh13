<?php
	$bUrl=Yii::app()->request->baseUrl;
	$str="";

	foreach($msg as $aPost){

		$str =$str. '<div class="msgblock">'.
			CHtml::imageButton(Html::getPersonalImgUrl($aPost->uid),
								array('class'=>'msgi','onclick'=>'tohome("'.CHtml::encode($aPost->uid).'")')).
				'<div class="msgk"><a href="'.$bUrl.'/profile/index/'.$aPost->uid.'.html" class="msgn">'.CHtml::encode($aPost->guser->nickname).'</a><p class="msgq"> :</p></div>'.
				'<div class="msgp">'.CHtml::encode($aPost->msg).'</div>'.
				'<div class="msgt">'.$aPost->time.'</div>'.
			'</div>';
	}  
	if(!$end)
		$str=$str. '<div id="moremsg" onmouseover="morestar()" onmouseout="morenormal()" onmousedown="moregray()" onmouseup="moremsg()" ><img id="moremsgimg" src="/ncufresh13/file/img/video/moremsg.png"></div>';

	echo $str;