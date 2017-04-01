<?php echo Html::blockHead('cnt','block');?>
<?php echo $error;?>
<?php Yii::app()->clientScript->registerMetaTag('10;url='.$returnUri, null, 'refresh'); ?>
<?php echo Html::blockBottom('cnt','block');?>