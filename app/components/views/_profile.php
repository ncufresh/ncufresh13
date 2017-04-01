<?php
	$name = Yii::app()->user->nickname;
	$uid = Yii::app()->user->getId();
	$bUrl = Yii::app()->request->baseUrl;
 	//echo CHtml::link('登出',Yii::app()->createUrl('site/logout'));


	echo CHtml::tag('img', array(
		'src' => $bUrl.'/file/img/logout.gif',
		'onclick' => "window.location='".Yii::app()->createUrl('site/logout')."';",
		'style' => "width:80px;
			cursor: pointer;
			position: absolute;
			top: 90px;
			left: -41px;"
			), '', false);

	echo CHtml::tag('img', array(
		'src' => Html::getPersonalImgWUrl($uid),
		'onclick' => "window.location='".$bUrl."/profile/index.html';",
		'style' => "width:85px;
		cursor: pointer;
		position: absolute;
		top: 10px;
		left: 36px;"
	), '', false);
	
	echo CHtml::tag('p', array(
		'style' => "width:85px;
		height: 50px;
		text-align: center;
		position: absolute;
		top: 121px;
		left: 36px;
		color: white"
	),$name,false);
?>