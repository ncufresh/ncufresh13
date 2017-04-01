

<?php echo Html::blockHead('test','none',true);?>
<?php echo Html::blockBottom('test','none',true);?>

<?php echo Html::blockHead('main','block');?>
	<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
	<div id="ajaxDiv" style="display:none;opacity:0.0;background-color:red">
	</div>
	<?php echo CHtml::ajaxButton ("要求ajaxcontroller更新資料",
	                              CController::createUrl('ajax/AjaxDynamicView'), 
	                              array(
	                              	'success' => 'js:function(html){
	                              		animate("test",html,true);
	                              	}'));
	?>
<?php echo Html::blockBottom('main','block');?>

