<?php echo Html::blockHead('error','block');?>
<div style="width:900px;height:590px;margin:0 auto;position:relative;">
	<div style="position: absolute;top: 211px;left: 396px;"><a href=<?php echo Yii::app()->createUrl('site/index');?>><img src="<?php echo Yii::app()->baseUrl;?>/file/img/errorHome.png"></a></div>
	<img src="<?php echo Yii::app()->baseUrl;?>/file/img/errorPage.png">
</div>
<?php echo Html::blockBottom('error','block');?>